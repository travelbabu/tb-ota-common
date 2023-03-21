<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class MaxLos extends Attribute
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $value;
    public const DEFAULT_VALUE = 31;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'value' => $this->value,
            'isUpdated' => $this->isUpdated,
        ]);
    }
    static function getDefaultInstance(): static
    {
        return new static([
            'value' => self::DEFAULT_VALUE,
            'isUpdated' => false
        ]);
    }
}
