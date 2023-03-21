<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\InventoryUpdate;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\ChannelLog;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class InventoryUpdateLog extends ChannelLog
{
    public $activityTypeID = 'INVENTORY_UPDATE';

    /**
     * @var InventoryUpdateLogDetails
     * @ODM\EmbedOne(targetDocument=InventoryUpdateLogDetails::class)
     */
    public $details;

    public function __construct(array $attributes = [])
    {
        $this->details = new InventoryUpdateLogDetails;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter(
            array_merge(parent::toArray(),[
                'activityTypeID' => $this->activityTypeID,
                'details' => isset($this->details) ? $this->details->toArray() : null
            ])
        );
    }
}