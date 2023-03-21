<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty\ChannelProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty\ChannelSpace;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ProductMapping extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $internalProductID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $internalProductName;

    /**
     * @var ArrayCollection
     * @ODM\EmbedMany(targetDocument=MappedProduct::class)
     */
    public $mappedProducts;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->mappedProducts = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @param PropertyProduct $product
     * @return ProductMapping
     * @throws Exception
     */
    public static function createFromPropertyProduct(PropertyProduct $product): ProductMapping
    {
        return new self([
            'internalProductID' => $product->id,
            'internalProductName' => $product->internalName,
        ]);
    }

    /**
     * @param ChannelSpace $channelSpace
     * @param ChannelProduct $channelProduct
     * @param bool $override
     * @return MappedProduct
     */
    public function mapChannelProduct(ChannelSpace $channelSpace, ChannelProduct $channelProduct, bool $override = true): MappedProduct
    {
        $mappedProductToBeInserted = MappedProduct::createFromChannelProduct($channelSpace, $channelProduct);

        /** @var MappedProduct $mappedProduct */
        foreach($this->mappedProducts as $i => $mappedProduct) {
            if($mappedProduct->externalProductID == $channelProduct->id) {
                if(!$override) {
                    throw new HttpException(400, 'Product already mapped');
                } else {
                    $this->mappedProducts->remove($i);
                }
            }
        }

        $this->mappedProducts->add($mappedProductToBeInserted);

        return $mappedProductToBeInserted;
    }

    /**
     * @param string $externalProductID
     * @return bool
     */
    public function hasMappedProduct(string $externalProductID): bool
    {
        foreach($this->mappedProduct as $mappedProduct) {
            if($mappedProduct->externalProductID == $externalProductID) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $externalProductID
     */
    public function removeMappedProduct(string $externalProductID)
    {
        foreach($this->mappedProducts as $i =>$mappedProduct) {
            if($mappedProduct->externalProductID == $externalProductID) {
                $this->mappedProducts->remove($i);
                return;
            }
        }
    }

    /**
     * @param int|PropertyProduct $product
     * @return bool
     */
    public function isFor(int|PropertyProduct $product): bool
    {
        $productID = PropertyProduct::resolveID($product);

        return $this->internalProductID == $productID;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'internalProductID'   => $this->internalProductID,
            'internalProductName' => $this->internalProductName,
            'mappedProducts'      => collect($this->mappedProducts)->toArray(),
        ]);
    }

    public function __clone()
    {
        $mappedProductsClone = new ArrayCollection;
        foreach($this->mappedProducts as $mappedProduct) {
            $mappedProductsClone->add(clone $mappedProduct);
        }
        $this->mappedProducts = $mappedProductsClone;
    }
}
