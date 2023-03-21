<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Employee\Employee;

class EmployeeRules
{
    public static function validType(): In
    {
        return new In([
            Employee::TYPE_SALES,
            Employee::TYPE_SUPPORT,
            Employee::TYPE_BD,
            Employee::TYPE_MANAGEMENT,
            Employee::TYPE_OTHER,
        ]);
    }

    public static function validStatus(): In
    {
        return new In([
            Employee::STATUS_ACTIVE,
            Employee::STATUS_INACTIVE,
        ]);
    }
}
