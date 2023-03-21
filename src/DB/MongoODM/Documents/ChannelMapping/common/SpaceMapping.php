<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use DemeterChain\A;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty\ChannelSpace;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class SpaceMapping extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $internalSpaceID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $internalSpaceName;

    /**
     * @var ArrayCollection
     * @ODM\EmbedMany(targetDocument=MappedSpace::class)
     */
    public $mappedSpaces;

    /**
     * Array of user reference objects
     * @var ArrayCollection
     * @ODM\EmbedMany(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common\ProductMapping::class)
     */
    public $productMappings;

    /**
     * @throws Exception
     */
    public function __construct(array $attributes = [])
    {
        $this->mappedSpaces = new ArrayCollection;
        $this->productMappings = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @param PropertySpace $space
     * @return SpaceMapping
     * @throws Exception
     */
    public static function createFromPropertySpace(PropertySpace $space): SpaceMapping
    {
        return new self([
            'internalSpaceID' => $space->id,
            'internalSpaceName' => $space->internalName,
        ]);
    }

    /**
     * @param ChannelSpace $channelSpace
     * @param bool $override
     * @return mappedSpace
     */
    public function mapChannelSpace(ChannelSpace $channelSpace, bool $override = true): mappedSpace
    {
        $mappedSpaceToBeInserted = MappedSpace::createFromChannelSpace($channelSpace);

        /** @var mappedSpace $mappedSpace */
        foreach($this->mappedSpaces as $i => $mappedSpace) {
            if($mappedSpace->externalProductID == $channelSpace->id) {
                if(!$override) {
                    throw new HttpException(400, 'Product already mapped');
                } else {
                    $this->mappedSpaces->remove($i);
                }
            }
        }

        $this->mappedSpaces->add($mappedSpaceToBeInserted);

        return $mappedSpaceToBeInserted;
    }

    /**
     * @param string $externalSpaceID
     * @return bool
     */
    public function hasMappedSpace(string $externalSpaceID): bool
    {
        foreach($this->mappedSpaces as $mappedSpace) {
            if($mappedSpace->externalSpaceID == $externalSpaceID) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $externalSpaceID
     */
    public function removeMappedSpace(string $externalSpaceID)
    {
        foreach($this->mappedSpaces as $i =>$mappedSpace) {
            if($mappedSpace->externalSpaceID == $externalSpaceID) {
                $this->mappedSpaces->remove($i);
                return;
            }
        }
    }


    /**
     * @param PropertyProduct|int $product
     * @return bool
     */
    public function hasMappingForProduct(PropertyProduct|int $product): bool
    {
        $productID = ($product instanceof PropertyProduct) ? $product->id : $product;

        return collect($this->productMappings)->contains('internalProductID', $productID);
    }

    /**
     * @param PropertySpace $space
     * @return bool
     */
    public function isFor(PropertySpace $space): bool
    {
        $spaceID = PropertySpace::resolveID($space);

        return $this->internalSpaceID == $spaceID;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'internalSpaceID'   => $this->internalSpaceID,
            'internalSpaceName' => $this->internalSpaceName,
            'mappedSpaces'      => collect($this->mappedSpaces)->toArray(),
            'productMappings'      => collect($this->productMappings)->toArray(),
        ]);
    }

    public function __clone()
    {
        $mappedSpacesClone = new ArrayCollection;
        foreach($this->mappedSpaces as $mappedSpace) {
            $mappedSpacesClone->add(clone $mappedSpace);
        }
        $this->mappedSpaces = $mappedSpacesClone;

        $productMappingsClone = new ArrayCollection;
        foreach($this->productMappings as $productMapping) {
            $productMappingsClone->add(clone $productMapping);
        }
        $this->productMappings = $productMappingsClone;
    }
}
