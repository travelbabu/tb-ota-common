<?php

namespace SYSOTEL\OTA\Common\Helpers\Traits;

trait RequestDefaultValuesTrait
{
    /**
     * Enhanced method to consider default values
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (method_exists($this, 'defaults')) {
            foreach ($this->defaults() as $key => $defaultValue) {
                if (!$this->has($key)) $this->merge([$key => $defaultValue]);
            }
        }
    }
}