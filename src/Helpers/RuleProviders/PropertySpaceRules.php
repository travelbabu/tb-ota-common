<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\SpaceView;
use SYSOTEL\OTA\Common\Rules\Exists;

class PropertySpaceRules
{
    /**
     * @param array $filters
     * @return Exists
     */
    public static function exists(array $filters = []) : Exists
    {
        return new Exists(PropertySpace::class, '_id', $filters);
    }

    /**
     * @return In
     */
    public static function validView(): In
    {
        return Rule::in([
            SpaceView::OCEAN_VIEW,
            SpaceView::MOUNTAIN_VIEW,
            SpaceView::VALLEY_VIEW,
            SpaceView::PALACE_VIEW,
            SpaceView::JUNGLE_VIEW,
            SpaceView::CITY_VIEW,
            SpaceView::GARDEN_VIEW,
            SpaceView::LAKE_VIEW,
            SpaceView::POOL_VIEW,
            SpaceView::RIVER_VIEW,
        ]);
    }

    /**
     * @return In
     */
    public static function validStatus(): In
    {
        return Rule::in([
            PropertySpace::STATUS_ACTIVE,
            PropertySpace::STATUS_DISABLED,
            PropertySpace::STATUS_DELETED,
        ]);
    }
}
