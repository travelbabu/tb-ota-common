<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Traits;

trait HasSearchKeywords
{
    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $searchKeywords = [];
}