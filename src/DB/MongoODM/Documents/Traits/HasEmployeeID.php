<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Traits;

trait HasEmployeeID
{
    /**
     * @var int|null
     * @ODM\Field(type="int")
     */
    public $employeeIdD;

    public function readableEmployeeID(): string
    {
        return "EMP-" . $this->employeeIdD;
    }
}