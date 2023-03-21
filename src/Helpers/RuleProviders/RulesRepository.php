<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Guest;
use SYSOTEL\OTA\Common\Rules\Exists;
use SYSOTEL\OTA\Common\Rules\Unique;
use SYSOTEL\OTA\Common\Rules\User\DoesNotHavePassword;
use SYSOTEL\OTA\Common\Rules\User\Password;
use SYSOTEL\OTA\Common\Rules\User\PasswordExists;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use JetBrains\PhpStorm\Pure;

class RulesRepository
{
    /**
     * @return In
     */
    public static function validMealPlanCodes(): In
    {
        return Rule::in([
            PropertyProduct::MEAL_PLAN_CODE_EP,
            PropertyProduct::MEAL_PLAN_CODE_CP,
            PropertyProduct::MEAL_PLAN_CODE_AP,
            PropertyProduct::MEAL_PLAN_CODE_MAP,
        ]);
    }

    /**
     * @return In
     */
    public static function validMarketSegments(): In
    {
        return Rule::in([
            Channel::SEGMENT_B2C,
            Channel::SEGMENT_B2B,
            Channel::SEGMENT_CORPORATE,
        ]);
    }
}
