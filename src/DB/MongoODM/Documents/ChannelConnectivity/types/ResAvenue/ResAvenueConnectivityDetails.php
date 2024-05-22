<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity\types\ResAvenue;


use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Amenity\ChannelConnectivity;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class ResAvenueConnectivityDetails extends ChannelConnectivity
{
    /**
     * @var string
     * @ODM\Field(type="string")
     *
     */
    public $username;

    /**
     * @var string
     * @ODM\Field(type="string")
     *
     */
    public $password;

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