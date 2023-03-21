<?php

namespace SYSOTEL\OTA\Common\Rules\User;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use SYSOTEL\OTA\Common\Rules\BaseRule;

/**
 * Class UniqueMobile
 *
 * @author Ravish
 */
class EmailExists extends BaseRule
{

    protected string $userType;

    /**
     * @param string $userType
     */
    public function __construct(string $userType)
    {
        $this->userType = $userType;
    }

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
            'type' => $this->userType
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