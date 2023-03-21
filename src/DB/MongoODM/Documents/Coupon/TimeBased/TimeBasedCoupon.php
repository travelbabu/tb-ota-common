<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Coupon\TimeBased;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Coupon\Coupon;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class TimeBasedCoupon extends Coupon
{
    public $type = 'TIME_BASED';

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $multiplier;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter(
            array_merge(parent::toArray(), [
                'type' => $this->type,
                'multipler' => $this->multiplier
            ])
        );
    }
}