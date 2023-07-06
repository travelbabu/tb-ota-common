<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PromotionDiscountConfig extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_FLAT = 'FLAT';
    public const TYPE_PERC = 'PERC';

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $value;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'type'  => $this->type,
            'value' => $this->value,
        ]);
    }
}
