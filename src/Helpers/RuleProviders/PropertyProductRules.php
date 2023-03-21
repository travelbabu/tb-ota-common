<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;
use SYSOTEL\OTA\Common\Rules\Exists;

class PropertyProductRules
{
    /**
     * @param array $filters
     * @return Exists
     */
    public static function exists(array $filters = []) : Exists
    {
        return new Exists(PropertyProduct::class, '_id', $filters);
    }

    /**
     * @return In
     */
    public static function validMealPlanCode(): In
    {
        return Rule::in([
            PropertyProduct::MEAL_PLAN_CODE_EP,
            PropertyProduct::MEAL_PLAN_CODE_CP,
            PropertyProduct::MEAL_PLAN_CODE_MAP,
            PropertyProduct::MEAL_PLAN_CODE_AP,
        ]);
    }

    /**
     * @return In
     */
    public static function validPaymentMode(): In
    {
        return Rule::in([
            PropertyProduct::PAYMENT_MODE_PAY_NOW,
            PropertyProduct::PAYMENT_MODE_PAY_PARTIAL,
//            PropertyProduct::PAYMENT_MODE_PAY_AT_PROPERTY,
        ]);
    }

    /**
     * @return In
     */
    public static function validPartialPaymentValueType(): In
    {
        return Rule::in([
//            PartialPayment::VALUE_TYPE_FLAT,
            PartialPayment::VALUE_TYPE_PERC,
        ]);
    }

    /**
     * @return In
     */
    public static function validStatus(): In
    {
        return Rule::in([
            PropertyProduct::STATUS_ACTIVE,
            PropertyProduct::STATUS_DISABLED,
            PropertyProduct::STATUS_DELETED,
        ]);
    }
}
