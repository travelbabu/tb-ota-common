<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelLogRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="channelLogs",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelLogRepository::class
 * )
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("activityTypeID")
 * @ODM\DiscriminatorMap({
 *     "RATE_UPDATE":Dedicated\RateUpdate\RateUpdateLog::class,
 *     "INVENTORY_UPDATE":Dedicated\InventoryUpdate\InventoryUpdateLog::class,
 * })
 * @ODM\HasLifecycleCallbacks
 */
abstract class ChannelLog extends Document
{
    use Macroable, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'channelLogs';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $baseChannelID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $connectedChannelID;

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $channelMappingID;

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
    */
    public $activityID;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $causer;

    /**
     * @var ObjectId[]
     * @ODM\Field(type="collection")
     */
    public $connectedLogIDs = [];

    /**
     * @var ChannelLogProperty
     * @ODM\EmbedOne(targetDocument=ChannelLogProperty::class)
     */
    public $property;

    /**
     * @var ChannelLogSpace
     * @ODM\EmbedOne(targetDocument=ChannelLogSpace::class)
     */
    public $space;

    /**
     * @var ChannelLogProperty
     * @ODM\EmbedOne(targetDocument=ChannelLogProperty::class)
     */
    public $product;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PARTIAL = 'PARTIAL';
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_INTERNAL_ERROR = 'INTERNAL_ERROR';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $requestDirection;
    public const REQUEST_DIRECTION_INCOMING = 'INCOMING';
    public const REQUEST_DIRECTION_OUTGOING = 'OUTGOING';


    /**
     * @var ArrayCollection
     * @ODM\EmbedMany(targetDocument=ChannelLogAttempt::class)
     */
    public $attempts;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $source;
    public const SOURCE_APP_INLINE_UPDATE = 'SYSOTEL_APP_INLINE_UPDATE';

    public function __construct(array $attributes = [])
    {
        $this->attempts = new ArrayCollection();

        parent::__construct($attributes);
    }

    /**
     * Returns true if the log can be retried
     *
     * @return bool
     */
    public function canReattempt(): bool
    {
        return $this->noOfAttempts() < 3;
    }

    /**
     * Returns number of attempts
     *
     * @return int
     */
    public function noOfAttempts(): int
    {
        return $this->attempts->count();
    }

    /**
     * @return $this
     */
    public function createNewAttempt(): static
    {
        $attempt = new ChannelLogAttempt;
        $attempt->markAsStarted();
        $attempt->status = ChannelLogAttempt::STATUS_PENDING;
        $this->attempts->add($attempt);
        return $this;
    }

    /**
     * @return ChannelLogAttempt|null
     */
    public function latestAttempt(): ?ChannelLogAttempt
    {
        return (! empty($this->attempts)) ? $this->attempts->last() : null;
    }

    /**
     * Returns number of retries
     *
     * @return int
     */
    public function noOfRetries(): int
    {
        $attempts = $this->noOfAttempts();

        return $attempts > 0 ? $attempts - 1 : 0;
    }

    /**
     * @param ObjectId|string|string[]|ObjectId[] $ids
     */
    public function addConnectedLogIDs(ObjectId|string|array $ids): static
    {
        foreach(Arr::wrap($ids) as $id) {

            $id = is_string($id) ? new ObjectId($id) : $id;

            $this->connectedLogsIDs[] = $id;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'                  => $this->id,
            'activityID'          => $this->activityID,
            'baseChannelID'       => $this->baseChannelID,
            'connectedChannelID'  => $this->connectedChannelID,
            'channelMappingID'    => $this->channelMappingID,
            'connectedLogIDs'     => $this->connectedLogIDs,
            'causer'              => $this->causer->toArray(),
            'property'            => $this->property->toArray(),
            'space'               => isset($this->space) ? $this->space->toArray() : null,
            'product'             => isset($this->product) ? $this->product->toArray() : null,
            'status'              => $this->status,
            'createdAt'           => $this->createdAt,
            'updatedAt'           => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return ChannelLogRepository
     */
    public static function repository(): ChannelLogRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
