<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Exception;
use Illuminate\Support\Traits\Macroable;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelMappingRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common\MappedProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common\MappedProperty;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common\MappedSpace;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common\ProductMapping;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common\SpaceMapping;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty\ChannelProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty\ChannelSpace;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="channelMappings",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelMappingRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class ChannelMapping extends Document
{
    use Macroable, HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'channelMappings';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $channelPropertyID;

    /**
     * @var MappedProperty
     * @ODM\EmbedOne (targetDocument=common\MappedProperty::class)
     */
    public $mappedProperty;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $baseChannelID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $connectedChannelID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_EXPIRED = 'EXPIRED';

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $autoMap;

    /**
     * Array of user reference objects
     * @var ArrayCollection
     * @ODM\EmbedMany(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common\SpaceMapping::class)
     */
    public $spaceMappings;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $rateType;
    public const RATE_TYPE_NET = 'NET';
    public const RATE_TYPE_SELL = 'SELL';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $markupType;
    public const MARKUP_TYPE_PERCENTAGE = 'PERC';
    public const MARKUP_TYPE_FLAT = 'FLAT';

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $markupValue;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $tax;
    public const TAX_INCLUSIVE = 'INC';
    public const TAX_EXCLUSIVE = 'EXC';

    /**
     * @var array
     */
    protected $defaults = [
        'autoMap' => false
    ];

    /**
     * @throws Exception
     */
    public function __construct(array $attributes = [])
    {
        $this->spaceMappings = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @param PropertySpace|int $space
     * @return bool
     */
    public function hasMappingForSpace(PropertySpace|int $space): bool
    {
        $spaceID = ($space instanceof PropertySpace) ? $space->id : $space;

        return collect($this->spaceMappings)->contains('internalSpaceID', $spaceID);
    }

    /**
     * @param PropertyProduct|int $product
     * @return bool
     */
    public function hasMappingForProduct(PropertyProduct|int $product): bool
    {
        $flag = false;
        foreach ($this->spaceMappings as $spaceMapping) {
            if ($spaceMapping->hasMappingForProduct($product)) {
                $flag = true;
                break;
            }
        }

        return $flag;
    }

    /**
     * @param PropertySpace|int $space
     * @return SpaceMapping|null
     */
    public function getSpaceMappingFor(PropertySpace|int $space): SpaceMapping|null
    {
        $spaceID = ($space instanceof PropertySpace) ? $space->id : $space;

        return collect($this->spaceMappings)->firstWhere('internalSpaceID', $spaceID);
    }

    /**
     * @param PropertySpace|int $space
     * @return MappedSpace[]
     */
    public function getMappedSpacesFor(PropertySpace|int $space): array
    {
        $spaceMapping = $this->getSpaceMappingFor($space);

        return isset($spaceMapping) ? $spaceMapping->mappedSpaces->toArray() : [];
    }

    /**
     * @param PropertyProduct|int $product
     * @param PropertySpace|int $space
     * @return ProductMapping|null
     */
    public function getProductMappingFor(PropertyProduct|int $product, PropertySpace|int $space): ProductMapping|null
    {
        if(! $spaceMapping = $this->getSpaceMappingFor($space)) {
            return null;
        }

        $productID = ($product instanceof PropertyProduct) ? $product->id : $product;

        return collect($spaceMapping->productMappings)->firstWhere('internalProductID', $productID);
    }

    /**
     * @param PropertyProduct|int $product
     * @param PropertySpace|int $space
     * @return MappedProduct[]
     */
    public function getMappedProductsFor(PropertyProduct|int $product, PropertySpace|int $space): array
    {
        $productMapping = $this->getProductMappingFor($product,$space);

        return isset($productMapping) ? $productMapping->mappedProducts->toArray() : [];
    }

    /**
     * Returns spaceIDs that has mappings
     *
     * @return array
     */
    public function getInternalSpaces(): array
    {
        return collect($this->spaceMappings)->pluck('internalSpaceID')->toArray();
    }

    /**
     * @param PropertySpace $space
     * @param ProductMapping $productMapping
     * @return $this
     * @throws Exception
     */
    public function addProductMapping(PropertySpace $space, ProductMapping $productMapping): self
    {
        $spaceMappingExists = false;
        foreach($this->spaceMappings as $i => $spaceMapping) {
            if($spaceMapping->internalSpaceID == $space->id) {
                $spaceMappingExists = true;
                // todo avoid duplication
                // check the existing product mappings first, if exist override
                $this->spaceMappings[$i]->productMappings->add($productMapping);
            }
        }

        if(!$spaceMappingExists) {

            $mapping = new SpaceMapping([
                'internalSpaceID' => $space->id,
                'internalSpaceName' => $space->internalName,
            ]);

            $mapping->productMappings->add($productMapping);

            $this->spaceMappings->add($mapping);
        }

        return $this;
    }

    /**
     * If override = true, remove existing mapped space with same ID as requested
     * and then add the new mapping.
     * If override = false, throw error if mapped already exists for space
     *
     * @param int|PropertySpace $internalSpace
     * @param ChannelSpace $channelSpace
     * @param bool $override
     * @return ChannelMapping
     * @throws Exception
     */
    public function mapChannelSpace(int|PropertySpace $internalSpace, ChannelSpace $channelSpace, bool $override = false): static
    {
        $internalSpaceID = $internalSpace instanceof PropertySpace ? $internalSpace->id : $internalSpace;

        if($this->hasMappingForSpace($internalSpaceID)) {

            /** @var SpaceMapping $spaceMapping */
            foreach($this->spaceMappings as $i => $spaceMapping) {
                if($spaceMapping->internalSpaceID == $internalSpaceID) {
                    $spaceMapping->mapChannelSpace($channelSpace, $override);
                    break;
                }
            }
        } else {
            $spaceMapping = SpaceMapping::createFromPropertySpace($internalSpace);
            $spaceMapping->mapChannelSpace($channelSpace);
            $this->spaceMappings->add($spaceMapping);
        }

        return $this;
    }

    /**
     * @param int|PropertySpace $internalSpace
     * @param $externalSpaceID
     * @return $this
     */
    public function removeMappedSpace(int|PropertySpace $internalSpace, $externalSpaceID, ): static
    {
        $internalSpaceID = $internalSpace instanceof PropertySpace ? $internalSpace->id : $internalSpace;

        /** @var SpaceMapping $spaceMapping */
        foreach($this->spaceMappings as $i => $spaceMapping) {
            if($spaceMapping->internalSpaceID == $internalSpaceID) {
                foreach($spaceMapping->mappedSpaces as $j => $mappedSpace) {
                    if($mappedSpace->externalSpaceID == $externalSpaceID) {
                        $this->spaceMappings[$i]->mappedSpaces->remove($j);
                        break;
                    }
                }
                break;
            }
        }

        return $this;
    }

    /**
     * @param int|PropertySpace $internalSpace
     * @param int|PropertyProduct $internalProduct
     * @param ChannelSpace $channelSpace
     * @param ChannelProduct $channelProduct
     * @param bool $override
     * @return $this
     * @throws Exception
     */
    public function mapChannelProduct(int|PropertySpace $internalSpace, int|PropertyProduct $internalProduct, ChanneLSpace $channelSpace, ChannelProduct $channelProduct, bool $override = false): static
    {
        $newProductMapping = ProductMapping::createFromPropertyProduct($internalProduct);
        $newSpaceMapping = SpaceMapping::createFromPropertySpace($internalSpace);


        if($this->hasMappingForSpace($internalSpace)) {
            if($this->hasMappingForProduct($internalProduct)) {

                /**
                 * @var SpaceMapping $spaceMapping
                 * @var ProductMapping $productMapping
                 */
                foreach($this->spaceMappings as $i => $spaceMapping) {
                    if($spaceMapping->internalSpaceID === $internalSpace->id) {
                        foreach($spaceMapping->productMappings as $j => $productMapping) {
                            if($productMapping->isFor($internalProduct)) {
                                $this->spaceMappings[$i]->productMappings[$j]->mapChannelProduct($channelSpace, $channelProduct, $override);
                                break;
                            }
                        }
                        break;
                    }
                }

            } else {
                foreach($this->spaceMappings as $i => $spaceMapping) {
                    if($spaceMapping->internalSpaceID === $internalSpace->id) {
                        $newSpaceMapping->productMappings->add($newProductMapping);
                        $this->spaceMappings[$i]->productMappings->add($newProductMapping);
                    }
                }
            }
        } else {
            $newProductMapping->mapChannelProduct($channelSpace, $channelProduct, $override);
            $newSpaceMapping->productMappings->add($newProductMapping);
            $this->spaceMappings->add($newSpaceMapping);
        }

        return $this;
    }

    /**
     * @param int|PropertyProduct $internalProduct
     * @param $channelProductID
     * @return $this
     */
    public function removeMappedProduct(int|PropertyProduct $internalProduct, $channelProductID): static
    {
        $internalProductID = $internalProduct instanceof PropertyProduct ? $internalProduct->id : $internalProduct;

        /** @var SpaceMapping $spaceMapping */
        /** @var ProductMapping $productMapping */
        foreach($this->spaceMappings as $i => $spaceMapping) {
            foreach($spaceMapping->productMappings as $j => $productMapping) {
                if($productMapping->internalProductID == $internalProductID) {
                    foreach($productMapping->mappedProducts as $k => $mappedProduct) {
                        if($mappedProduct->externalProductID == $channelProductID) {
                            $this->spaceMappings[$i]->productMappings[$j]->mappedProducts->remove($k);
                            break;
                        }
                    }
                    break;
                }
            }
        }

        return $this;
    }

    /**
     * Returns IDs of internal spaces
     * that has mapped spaces
     *
     * @return array
     */
    public function getConnectedSpaceIDs(): array
    {
        return collect($this->spaceMappings)->pluck('internalSpaceID')->toArray();
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'channelPropertyID' => $this->channelPropertyID,
            'propertyID' => $this->propertyID,
            'baseChannelID' => $this->baseChannelID,
            'connectedChannelID' => $this->connectedChannelID,
            'status' => $this->status,
            'autoMap' => $this->autoMap,
            'mappedProperty' => $this->mappedProperty,
            'spaceMappings' => collect($this->spaceMappings)->toArray(),
            'markupType' => $this->markupType,
            'markupValue' => $this->markupValue,
            'tax' => $this->tax,
            'rateType' => $this->rateType,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);
    }

    /**
     * @return ChannelMappingRepository
     */
    public static function repository(): ChannelMappingRepository
    {
        return DocumentManager::getRepository(self::class);
    }

    public function __clone()
    {
        if ($this->id) {
            $this->id = null;
            $this->channelPropertyID = null;
            $this->createdAt = null;
            $this->mappedProperty = clone $this->mappedProperty;

            $spaceMappingsClone = new ArrayCollection;
            foreach($this->spaceMappings as $spaceMapping) {
                $spaceMappingsClone->add(clone $spaceMapping);
            }

            $this->spaceMappings = $spaceMappingsClone;
        }
    }
}

