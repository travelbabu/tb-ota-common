<?php

namespace SYSOTEL\OTA\Common\Rules;

class Tan extends RegexRule
{
    /**
     * Regex pattern
     *
     * @return string
     */
    public function pattern(): string
    {
        return '/^S4[0-9]{5}$^S1/';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid TAN number';
    }
}
