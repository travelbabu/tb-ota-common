<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Coupon\ServiceChargeFriendly;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Coupon\Coupon;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class ServiceChargeFriendlyCoupon extends Coupon
{
    public $type = 'SERVICE_CHARGE_FRIENDLY';

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter(
            array_merge(parent::toArray(), [

            ])
        );
    }
}