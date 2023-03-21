<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

class ChannelRules
{
    /**
     * @return In
     */
    public static function validInternalChannel(): In
    {
        return Rule::in([
            Channel::ID_INTERNAL_B2C,
            Channel::ID_INTERNAL_B2B,
            Channel::ID_INTERNAL_CORPORATE,
        ]);
    }
}
