<?php

namespace SYSOTEL\OTA\Common\Rules;

class AadhaarNumber extends RegexRule
{
    /**
     * Regex pattern
     *
     * @return string
     */
    public function pattern(): string
    {
        return '/^\d{4}\s\d{4}\s\d{4}$/';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid Aadhaar number';
    }
}
