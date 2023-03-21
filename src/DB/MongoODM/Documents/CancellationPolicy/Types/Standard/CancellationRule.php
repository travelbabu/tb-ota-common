<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy\Types\Standard;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class CancellationRule extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $deadlineInHours;

    /**
     * @var CancellationPenalty
     * @ODM\EmbedOne(targetDocument=CancellationPenalty::class)
     */
    public $penalty;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'deadlineInHours' => $this->deadlineInHours,
            'penalty' => $this->penalty->toArray(),
        ]);
    }
}
