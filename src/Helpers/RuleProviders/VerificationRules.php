<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;

class VerificationRules extends UserRules
{
    public static function validStatus(): In
    {
        return new In([
            Verification::STATUS_PENDING,
            Verification::STATUS_REJECTED,
            Verification::STATUS_APPROVED,
        ]);
    }
}
