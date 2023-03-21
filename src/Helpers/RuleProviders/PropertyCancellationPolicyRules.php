<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCancellationPolicy\CancellationPolicy;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCancellationPolicy\Types\Standard\CancellationPenalty;

class PropertyCancellationPolicyRules
{
    /**
     * @return In
     */
    public static function validCancellationPolicyType(): In
    {
        return Rule::in([
            CancellationPolicy::TYPE_STANDARD,
            CancellationPolicy::TYPE_CUSTOM,
        ]);
    }

    /**
     * @return In
     */
    public static function validCancellationChargesType(): In
    {
        return Rule::in([
            CancellationPenalty::VALUE_TYPE_FLAT,
            CancellationPenalty::VALUE_TYPE_PERC
        ]);
    }

    /**
     * @return In
     */
    public static function validCancellationChargesOnValue(): In
    {
        return Rule::in([
            CancellationPenalty::ON_ENTIRE_BOOKING,
            CancellationPenalty::ON_FIRST_NIGHT
        ]);
    }
}
