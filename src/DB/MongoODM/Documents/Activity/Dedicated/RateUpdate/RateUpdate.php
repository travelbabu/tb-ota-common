<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity\Dedicated\RateUpdate;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity\Activity;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity\ActivityType;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class RateUpdate extends Activity
{
    public $activityTypeID = ActivityType::RATE_UPDATE;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), arrayFilter([

        ]));
    }
}
