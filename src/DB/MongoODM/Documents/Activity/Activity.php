<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="activities",
 * )
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("activityTypeID")
 * @ODM\DiscriminatorMap({
 *     "INVENTORY_UPDATE":Dedicated\InventoryUpdate\InventoryUpdate::class,
 *     "RATE_UPDATE":Dedicated\RateUpdate\RateUpdate::class,
 * })
 * @ODM\HasLifecycleCallbacks
 */
abstract class Activity extends Document
{
    use HasRepository, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'activities';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var ActivityProperty
     * @ODM\EmbedOne(targetDocument=ActivityProperty::class)
     */
    public $property;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $causer;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_PENDING = 'FAILED';
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_PARTIAL = 'PARTIAL';

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $recordedAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $confirmedAt;

    public function markAsConfirmed()
    {
        $this->confirmedAt = now();
    }

    /**
     * @inheritDoc
     */
    public function createdAtFieldName(): string
    {
        return 'recordedAt';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'         => $this->id,
            'causer'     => toArrayOrNull($this->causer),
            'property'   => toArrayOrNull($this->property),
            'recordedAt' => $this->recordedAt,
            'confirmedAt' => $this->confirmedAt,
            'updatedAt'  => $this->updatedAt,
        ]);
    }
}
