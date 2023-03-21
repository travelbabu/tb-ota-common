<?php

namespace SYSOTEL\OTA\Common\Rules\User;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use SYSOTEL\OTA\Common\Rules\BaseRule;

/**
 * Class UniqueMobile
 *
 * @author Ravish
 */
class AdminEmail extends BaseRule
{
    /**
     * Regex pattern
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $user = User::repository()->findOneBy([
            'email.id' => $value,
            'type' => User::USER_TYPE_ADMIN
        ]);

        return isset($user);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Email not found';
    }
}