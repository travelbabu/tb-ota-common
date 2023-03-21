<?php

namespace SYSOTEL\OTA\Common\Rules\User;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use SYSOTEL\OTA\Common\Rules\BaseRule;

/**
 * Class UniqueEmail
 *
 * @author Ravish
*/
class DoesNotHavePassword extends BaseRule
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
            ->field('password')->exists(false)
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
        return 'Please complete the account setup.';
    }
}
