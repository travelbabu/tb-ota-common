<?php

namespace SYSOTEL\OTA\Common\Helpers\Parsers;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;

class PropertyParser
{
    protected Property $property;

    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    /**
     * Text representation of number of users assigned
     *
     * @return string
     */
    public function assignedUsersString(): string
    {
        $numberOfUsers = $this->property->users->count();
        $postfix = ($numberOfUsers > 1) ? 'Users' : 'User';

        return $numberOfUsers . ' ' . $postfix;
    }
}