<?php

namespace SYSOTEL\OTA\Common\Helpers\Parsers;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

class UserParser
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function genderString(): string
    {
        if(!isset($this->user->gender)) {
            return '';
        }

        return match($this->user->gender) {
            User::GENDER_FEMALE => 'Female',
            User::GENDER_MALE => 'Male',
            default => 'Other'
        };
    }
}