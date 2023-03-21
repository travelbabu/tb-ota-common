<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\Rules\Exists;

class PropertyRules
{
    /**
     * @param array $filters
     * @return Exists
     */
    public static function exists(array $filters = []) : Exists
    {
        return new Exists(Property::class, '_id', $filters);
    }

    /**
     * @return In
     */
    public static function validStarRating(): In
    {
        return Rule::in(range(1,5));
    }

    /**
     * @return In
     */
    public static function validStatus(): In
    {
        return Rule::in([
            Property::STATUS_VERIFICATION_PENDING,
            Property::STATUS_ACTIVE,
            Property::STATUS_DISABLED,
            Property::STATUS_BLOCKED,
        ]);
    }

    /**
     * @return In
     */
    public static function validType(): In
    {
        return Rule::in([
            Property::TYPE_HOTEL,
            Property::TYPE_RESORT,
            Property::TYPE_HOMESTAY,
            Property::TYPE_VILLA,
            Property::TYPE_APARTMENT,
            Property::TYPE_GUEST_HOUSE,
            Property::TYPE_LODGE,
            Property::TYPE_HOUSEBOAT,
            Property::TYPE_FARM_HOUSE,
            Property::TYPE_PALACE,
            Property::TYPE_MOTEL,
            Property::TYPE_DHARAMSHALA,
            Property::TYPE_COTTAGE,
            Property::TYPE_CAMP,
        ]);
    }

    /**
     * @return In
     */
    public static function validBaseCurrency(): In
    {
        return Rule::in(Property::VALID_BASE_CURRENCIES);
    }
}
