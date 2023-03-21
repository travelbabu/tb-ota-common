<?php

namespace SYSOTEL\OTA\Common\Rules\PropertySpace;

use SYSOTEL\OTA\Common\Rules\BaseRule;

/**
 * Class UniqueMobile
 *
 * @author Ravish
 */
class ValidExtraBedsValue extends BaseRule
{
    protected $baseOccupancy;
    protected $maxOccupancy;
    protected $message;



    public function __construct($baseOccupancy, $maxOccupancy)
    {
        $this->baseOccupancy = $baseOccupancy;
        $this->maxOccupancy = $maxOccupancy;
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
        $maxOccupancy = (int) $this->maxOccupancy;
        $baseOccupancy = (int) $this->baseOccupancy;
        $maxExtraBeds = (int) $value;

        if( ! ($maxExtraBeds <= ($maxOccupancy - $baseOccupancy))) {
            $this->message = 'MaxExtraBeds should be less than or equal to (MaxOccupancy - BaseOccupancy)';
            return false;
        }

        else if($baseOccupancy == 4 && $maxExtraBeds != ($maxOccupancy - 4)) {
            $requiredValue = $maxOccupancy - 4;
            $this->message = "Extra beds value should be {$requiredValue}";
            return false;
        }


        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
