<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy\Types\Standard;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class CancellationPenalty extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $valueType;
    public const VALUE_TYPE_FLAT = 'FLAT';
    public const VALUE_TYPE_PERC = 'PERC';

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $value;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $on;
    public const ON_BOOKING_AMOUNT = 'BOOKING_AMOUNT';

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'type'  => $this->valueType,
            'value' => $this->value,
            'on'    => $this->on,
        ]);
    }
}
