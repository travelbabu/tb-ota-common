<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCacheLog;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="propertyCacheLogs"
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyCacheLog extends Document
{
    use HasTimestamps, HasRepository, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyCacheLogs';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    public const STATUS_ACTIVE = 'SUCCESS';
    public const STATUS_FAILED = 'FAILED';

    /**
     * @var Summary
     * @ODM\EmbedOne (targetDocument=Summary::class)
     */
    public $summary;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->summary = new Summary();

        parent::__construct($attributes);
    }

    /**
     * @return $this
     */
    public function markAsStarted(): static
    {
        $this->status = self::STATUS_IN_PROGRESS;
        $this->summary->startedAt = now();
        return $this;
    }

    /**
     * @return $this
     */
    public function markAsCompleted(): static
    {
        $this->status = self::STATUS_ACTIVE;
        $this->summary->completedAt = now();
        return $this;
    }

    /**
     * @return $this
     */
    public function markAsFailed(): static
    {
        $this->status = self::STATUS_FAILED;
        $this->summary->completedAt = now();
        return $this;
    }

    /**
     * @var string[]
     */
    protected $defaults = [
        'status' => self::STATUS_IN_PROGRESS
    ];

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'         => $this->id,
            'status'     => $this->status,
            'summary'    => toArrayOrNull($this->summary),
            'createdAt'  => $this->createdAt,
            'updatedAt'  => $this->updatedAt,
        ]);
    }
}
