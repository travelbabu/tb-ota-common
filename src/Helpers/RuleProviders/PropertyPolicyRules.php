<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckInPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckOutPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\PropertyRules;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

class PropertyPolicyRules
{
    /**
     * @return In
     */
    public static function validEarlyCheckInInstruction(): In
    {
        return Rule::in([
            CheckInPolicy::EARLY_CHECK_IN_ALLOWED,
            CheckInPolicy::EARLY_CHECK_IN_NOT_ALLOWED,
            CheckInPolicy::EARLY_CHECK_IN_AS_PER_AVAILABILITY,
        ]);
    }

    /**
     * @return In
     */
    public static function validLateCheckOutInstruction(): In
    {
        return Rule::in([
            CheckOutPolicy::LATE_CHECK_OUT_ALLOWED,
            CheckOutPolicy::LATE_CHECK_OUT_NOT_ALLOWED,
            CheckOutPolicy::LATE_CHECK_OUT_AS_PER_AVAILABILITY,
        ]);
    }

    /**
     * @return In
     */
    public static function validPropertyItem(): In
    {
        return Rule::in([
            PropertyRules::PET_ALLOWED,
            PropertyRules::PAYMENT_CARD_ACCEPTED,
            PropertyRules::DOCUMENTS_REQUIRED_WHILE_CHECK_IN,
            PropertyRules::SUITABLE_FOR_CHILDREN,
            PropertyRules::COUPLE_FRIENDLY,
            PropertyRules::LOCAL_ID_ALLOWED,
        ]);
    }
}
