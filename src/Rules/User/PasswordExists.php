<?php

namespace SYSOTEL\OTA\Common\Rules\User;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use SYSOTEL\OTA\Common\Rules\BaseRule;

/**
 * Class UniqueEmail
 *
 * @author Ravish
*/
class PasswordExists extends BaseRule
{
    /**
     * Validation
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $result = User::queryBuilder()
                      ->field('email.id')->equals($value)
                      ->field('password')->exists(true)
                      ->getQuery()
                      ->getSingleResult();

        return isset($result);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Password already exists.';
    }
}
