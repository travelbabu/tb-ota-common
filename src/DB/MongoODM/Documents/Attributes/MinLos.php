<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class MinLos extends Attribute
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $value;
    public const DEFAULT_VALUE = 1;

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
