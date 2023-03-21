<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\Rules;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class CovidRule extends EmbeddedDocument
{
    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isTestRequired;

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
        $str = ($this->isTestRequired === true)
            ? 'Covid 19 test is required for every guest while check-in'
            : '';

        if($this->note) {
            $str .= ' ' . $this->note;
        }

        return $str;
    }

    public function toArray(): array
    {
        return arrayFilter([
            'isTestRequired' => $this->isTestRequired,
            'note' => $this->note,
        ]);
    }
}