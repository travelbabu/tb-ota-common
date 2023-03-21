<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Coupon\DirectDiscount;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Coupon\Coupon;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class DirectDiscountCoupon extends Coupon
{
    public $type = 'DIRECT_DISCOUNT';

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $minGuestPayableAmount;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $discountAmount;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter(
            array_merge(parent::toArray(), [
                'minGuestPayableAmount' => $this->minGuestPayableAmount,
                'discountAmount' => $this->discountAmountr
            ])
        );
    }
}