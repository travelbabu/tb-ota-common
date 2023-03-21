<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use MongoDB\BSON\ObjectId;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class ChannelLogAttempt extends EmbeddedDocument
{
    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $startedAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $completedAt;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_PARTIAL = 'PARTIAL';
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_INTERNAL_ERROR = 'INTERNAL_ERROR';

    /**
     * @var ChannelLogApiCall
     * @ODM\EmbedOne  (targetDocument=ChannelLogApiCall::class)
     */
    public $apiCall;

    public function __construct(array $attributes = [])
    {
        $this->apiCalls = new ArrayCollection();

        parent::__construct($attributes);
    }

    /**
     * Assign started at attribute as now
     * @return ChannelLogAttempt
     */
    public function markAsStarted(): static
    {
        $this->startedAt = now();

        return $this;
    }

    /**
     * Assign completed at attribute as now
     * @return ChannelLogAttempt
     */
    public function markAsCompleted(): static
    {
        $this->completedAt = now();

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'startedAt' => $this->startedAt,
            'completedAt' => $this->completedAt,
            'status' => $this->status,
            'apiDetails' => $this->apiDetails->toArray(),
        ]);
    }
}
