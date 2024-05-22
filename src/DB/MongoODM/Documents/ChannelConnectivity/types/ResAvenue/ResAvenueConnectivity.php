<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity\types\ResAvenue;


use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity\ChannelConnectivity;
use SYSOTEL\OTA\Common\Helpers\Enums;

use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class ResAvenueConnectivity extends ChannelConnectivity
{
    /**
     * @var ResAvenueConnectivityDetails
     * @ODM\EmbedOne(targetDocument=ResAvenueConnectivityDetails::class)
     *
     */
    public $details;

    public function getChannelID(): string
    {
        return Enums::CHANNEL_ID_RESAVENUE;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter(
            array_merge(parent::toArray(),[

            ])
        );
    }
}