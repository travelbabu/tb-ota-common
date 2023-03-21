<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyChannelConnection;

class PropertyChannelConnectionRules
{
    /**
     * @return In
     */
    public static function validStatuses(): In
    {
        return Rule::in([
            PropertyChannelConnection::STATUS_ACTIVE,
            PropertyChannelConnection::STATUS_DISABLED,
            PropertyChannelConnection::STATUS_VERIFICATION_PENDING,
        ]);
    }

    /**
     * @return In
     */
    public static function validEditableStatusesForUser(): In
    {
        return Rule::in([
            PropertyChannelConnection::STATUS_ACTIVE,
            PropertyChannelConnection::STATUS_DISABLED,
        ]);
    }
}
