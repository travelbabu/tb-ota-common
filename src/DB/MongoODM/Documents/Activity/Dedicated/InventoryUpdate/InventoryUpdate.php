<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity\Dedicated\InventoryUpdate;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity\Activity;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity\ActivityType;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class InventoryUpdate extends Activity
{
    public $activityTypeID = ActivityType::INVENTORY_UPDATE;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), arrayFilter([

        ]));
    }
}
