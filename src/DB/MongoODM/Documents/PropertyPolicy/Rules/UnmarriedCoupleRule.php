<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\Rules;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class UnmarriedCoupleRule extends EmbeddedDocument
{
    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isAllowed;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $note;

    /**
     * @return string
     */
    public function description(): string
    {
        $str = '';
        if(isset($this->isAllowed)) {
            $flag = $this->isAllowed === true ? 'couple friendly' : 'NOT couple friendly';
            $str = "Property is $flag.";
            if($this->note) {
                $str .= ' ' . $this->note;
            }
        }

        return $str;
    }

    public function toArray(): array
    {
        return arrayFilter([
            'isAllowed' => $this->isAllowed,
            'note' => $this->note,
        ]);
    }
}