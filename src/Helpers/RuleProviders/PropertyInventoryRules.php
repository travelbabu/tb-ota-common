<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyInventory\PropertyInventory;

class PropertyInventoryRules
{
    /**
     * @return In
     */
    public static function validRateTypes(): In
    {
        return Rule::in([
            PropertyInventory::INVENTORY_TYPE_STANDARD_HOTEL_INVENTORY
        ]);
    }
}
