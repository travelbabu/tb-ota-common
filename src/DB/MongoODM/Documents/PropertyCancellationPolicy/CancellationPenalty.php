<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCancellationPolicy;

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
    public $type;
    public const TYPE_PERC = 'PERC';

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $value;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isNonRefundable;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'type' => $this->type,
            'value' => $this->value,
            'isNonRefundable' => $this->isNonRefundable,
        ]);
    }
}
