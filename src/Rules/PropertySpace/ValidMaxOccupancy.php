<?php

namespace SYSOTEL\OTA\Common\Rules\PropertySpace;

use SYSOTEL\OTA\Common\Rules\BaseRule;

/**
 * Class UniqueMobile
 *
 * @author Ravish
 */
class ValidMaxOccupancy extends BaseRule
{
    protected $baseOccupancy;


    public function __construct($baseOccupancy)
    {
        $this->baseOccupancy = $baseOccupancy;
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
        return is_numeric($this->baseOccupancy)
            && ($value >= $this->baseOccupancy);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Maximum occupancy should be greater than or equal to base occupancy';
    }
}