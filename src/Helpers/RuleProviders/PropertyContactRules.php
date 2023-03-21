<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyContact\PropertyContact;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

class PropertyContactRules
{
    /**
     * @return In
     */
    public static function validContactType(): In
    {
        return Rule::in([
            PropertyContact::TYPE_RESERVATION,
            PropertyContact::TYPE_GENERAL_INQUIRY,
            PropertyContact::TYPE_ACCOUNTS,
            PropertyContact::TYPE_INVENTORY,
        ]);
    }

    /**
     * @return In
     */
    public static function validNotificationType(): In
    {
        return Rule::in([
            PropertyContact::NOTIFICATION_INQUIRY,
            PropertyContact::NOTIFICATION_BOOKING,
        ]);
    }
}
