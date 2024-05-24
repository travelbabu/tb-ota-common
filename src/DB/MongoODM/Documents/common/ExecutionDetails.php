<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class ExecutionDetails extends EmbeddedDocument
{
    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $startedAt;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $completedAt;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $executionInMillis;

    public function markAsStarted()
    {
        $this->startedAt = now();

        return $this;
    }

    public function markAsCompleted()
    {
        $this->completedAt = now();
        if($this->startedAt) {
            $this->completedAt = $this->startedAt->diffInMilliseconds($this->completedAt);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            
        ]);
    }
}
