<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyRate\PropertyRate;

class PropertyRateRules
{
    /**
     * @return In
     */
    public static function validRateTypes(): In
    {
        return Rule::in([
            PropertyRate::RATE_TYPE_HOTEL_STANDARD_RATE
        ]);
    }
}
