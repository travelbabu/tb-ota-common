<?php

namespace SYSOTEL\OTA\Common\Rules\User;

use SYSOTEL\OTA\Common\Rules\BaseRule;

/**
 * Class UniqueMobile
 *
 * @author Ravish
 */
class Password extends BaseRule
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
        $number = preg_match('@[0-9]@', $value);
        $uppercase = preg_match('@[A-Z]@', $value);
        $lowercase = preg_match('@[a-z]@', $value);
        $specialChars = preg_match('@[^\w]@', $value);

        return (strlen($value) >= 8 && $number && $uppercase && $lowercase && $specialChars);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Password must contain at least one number, uppercase letter, lowercase letter and special character. Password length should be at least 8 characters.';
    }
}
