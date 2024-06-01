<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\ProvideInventory;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\ChannelLog;
use SYSOTEL\OTA\Common\Helpers\Enums;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class ProvideInventoryLog extends ChannelLog
{
    /**
     * @var ?ProvideInventoryDetails
     * @ODM\EmbedOne(targetDocument=ProvideInventoryDetails::class)
     */
    public $details;

    public function __construct(array $attributes = [])
    {
        $this->details = new ProvideInventoryDetails;

        parent::__construct($attributes);
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

    /**
     * @return string
     */
    public function getType(): string
    {
        return Enums::CHANNEL_LOG_PROVIDE_PROPERTY_INVENTORY;
    }
}