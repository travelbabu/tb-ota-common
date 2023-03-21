<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty\ChannelProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty\ChannelSpace;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class MappedProduct extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $externalSpaceID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $externalSpaceName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $externalProductID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $externalProductName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $dailyRateEquivalent;

    /**
     * @param ChannelSpace $channelSpace
     * @param ChannelProduct $channelProduct
     * @return MappedProduct
     */
    public static function createFromChannelProduct(ChannelSpace $channelSpace, ChannelProduct $channelProduct): MappedProduct
    {
        return new self([
            'externalSpaceID' => $channelSpace->id,
            'externalSpaceName' => $channelSpace->name,
            'externalProductID' => $channelProduct->id,
            'externalProductName' => $channelProduct->name,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'externalSpaceID'   => $this->externalSpaceID,
            'externalSpaceName' => $this->externalSpaceName,
            'externalProductID'   => $this->externalProductID,
            'externalProductName' => $this->externalProductName,
            'dailyRateEquivalent' => $this->dailyRateEquivalent,
        ]);
    }
}
