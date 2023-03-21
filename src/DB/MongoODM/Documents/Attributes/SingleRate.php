<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class SingleRate extends Attribute
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $sellRate;
    public const DEFAULT_SELL_RATE = 0;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return [
            'sellRate' => $this->sellRate,
            'isUpdated' => $this->isUpdated,
        ];
    }

    static function getDefaultInstance(): static
    {
        return new static([
            'sellRate' => self::DEFAULT_SELL_RATE,
            'isUpdated' => false
        ]);
    }
}
