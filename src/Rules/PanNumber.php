<?php

namespace SYSOTEL\OTA\Common\Rules;

class PanNumber extends RegexRule
{
    /**
     * Regex pattern
     *
     * @return string
     */
    public function pattern(): string
    {
        return '/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid PAN number';
    }
}
