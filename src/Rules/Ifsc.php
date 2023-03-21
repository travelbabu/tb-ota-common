<?php

namespace SYSOTEL\OTA\Common\Rules;

class Ifsc extends RegexRule
{
    /**
     * Regex pattern
     *
     * @return string
     */
    public function pattern(): string
    {
        return '/^[A-Z]{4}0[A-Z0-9]{6}$/';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid IFSC code';
    }
}
