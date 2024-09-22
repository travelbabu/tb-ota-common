<?php

namespace SYSOTEL\OTA\Common\Enums;

use function SYSOTEL\OTA\Common\Helpers\readableConstant;

enum ReviewCategory: string
{
    case SERVICE = 'SERVICE';
    case CLEANLINESS = 'CLEANLINESS';
    case SLEEP_QUALITY = 'SLEEP_QUALITY';
    case LOCATION = 'LOCATION';
    case SPACE = 'SPACE';
    case BREAKFAST = 'BREAKFAST';
    case VALUE = 'VALUE';
    case SPA = 'SPA';
    case ROOM = 'ROOM';
    case COMFORT = 'COMFORT';
    case FACILITIES = 'FACILITIES';
    case STAFF = 'STAFF';
    case VALUE_FOR_MONEY = 'VALUE_FOR_MONEY';
    case FREE_WIFI = 'FREE_WIFI';
    case FOOD_DRINK = 'FOOD_DRINK';
    case HOTEL_CONDITION = 'HOTEL_CONDITION';
    case POOL = 'POOL';

    /**
     * @return string
     */
    public function label(): string
    {
        return readableConstant($this->value);
    }
}
