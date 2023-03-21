<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="counters")
 */
class Counter extends Document
{
    use HasRepository, CanResolveStringID;

    /**
     * @inheritdoc
     */
    protected string $collection = 'counters';

    /**
     * @var string
     */
    protected string $keyType = 'string';

    /**
     * @var string
     * @ODM\Id(strategy="none"))
     */
    public $id;

    /**
     * Counter value
     *
     * @var int
     * @ODM\Field(type="int")
     */
    public $value;

    /**
     * @param int $by
     * @return int
     */
    public function increment(int $by = 1): int
    {
        return $this->value += $by;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
        ];
    }
}
