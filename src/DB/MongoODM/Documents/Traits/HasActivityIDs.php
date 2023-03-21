<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Traits;

trait HasActivityIDs
{
    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $activityIDs = [];
}