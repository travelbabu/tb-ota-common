<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount\AgentAccount;

class AgentAccountRules extends UserRules
{
    public static function validStatus(): In
    {
        return new In([
            AgentAccount::STATUS_VERIFICATION_PENDING,
            AgentAccount::STATUS_ACTIVE,
            AgentAccount::STATUS_INACTIVE,
        ]);
    }
}
