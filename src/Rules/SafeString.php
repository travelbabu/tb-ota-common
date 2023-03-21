<?php

namespace SYSOTEL\OTA\Common\Rules;

class SafeString extends RegexRule
{
    /**
     * Regex pattern
     *
     * @return string
     */
    public function pattern(): string
    {
        return '/^[a-z\d\-_\s\.]+$/i';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid value';
    }
}
