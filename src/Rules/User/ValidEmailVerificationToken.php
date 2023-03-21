<?php

namespace SYSOTEL\OTA\Common\Rules\User;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use SYSOTEL\OTA\Common\Rules\BaseRule;

/**
 * Class UniqueMobile
 *
 * @author Ravish
 */
class ValidEmailVerificationToken extends BaseRule
{
    protected $email;

    public function __construct(string $email)
    {
        $this->email = $email;
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
            'email.id' => $this->email,
            'email.verificationToken' => $value
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
        return 'Invalid token';
    }
}