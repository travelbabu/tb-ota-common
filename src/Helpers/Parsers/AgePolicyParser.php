<?php

namespace SYSOTEL\OTA\Common\Helpers\Parsers;


use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\AgePolicy;

class AgePolicyParser
{
    protected AgePolicy $policy;

    public function __construct(AgePolicy $policy)
    {
        $this->policy = $policy;
    }

    /**
     * @return string
     */
    public function infantAgeDefinition(): string
    {
        return "A guest with age {$this->policy->infantAgeThreshold} or below is considered an infant.";
    }

    /**
     * @return string
     */
    public function childAgeDefinition(): string
    {
        return "A guest with age between {$this->policy->infantAgeThreshold} and {$this->policy->childAgeThreshold} is considered a child.";
    }

    /**
     * @return string
     */
    public function adultAgeDefinition(): string
    {
        return "A guest with age above {$this->policy->childAgeThreshold} is considered an adult.";
    }

    /**
     * @return string
     */
    public function freeChildDefinition(): string
    {
        $guest = $this->policy->noOfFreeChildGranted != 1 ? 'guests' : 'guest';
        $is = $this->policy->noOfFreeChildGranted != 1 ? 'area' : 'is';

        return "{$this->policy->noOfFreeChildGranted} $guest below age {$this->policy->freeChildThreshold} {$is} allowed for FREE when used existing bedding.";
    }
}
