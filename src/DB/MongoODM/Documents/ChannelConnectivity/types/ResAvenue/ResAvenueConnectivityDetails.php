<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity\types\ResAvenue;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ResAvenueConnectivityDetails extends EmbeddedDocument
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