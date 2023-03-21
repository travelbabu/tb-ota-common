<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PartialPayment extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $valueType;
    public const VALUE_TYPE_FLAT = 'FLAT';
    public const VALUE_TYPE_PERC = 'PERC';

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $value;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'valueType'  => $this->valueType,
            'value' => $this->value,
        ]);
    }
}
