<?php

namespace SYSOTEL\OTA\Common\Rules;

abstract class RegexRule extends BaseRule
{
    /**
     * Child classes needs to implement this method
     * which should return a regex string
     *
     * @return string
     */
    abstract public function pattern(): string;

    /**
     * Determine if the validation rule passes.
     *
     * @param  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match($this->pattern(),$value);
    }
}
