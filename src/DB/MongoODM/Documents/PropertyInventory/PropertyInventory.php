<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyInventory;

use Delta4op\MongoODM\Documents\Document;
use Carbon\Carbon;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Arr;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyInventoryRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardSpaceAttributes;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="propertyInventories",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyInventoryRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyInventory extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyInventories';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $spaceID;

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
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $startDate;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $endDate;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_SUCCESS = 'SUCCESS';

    /**
     * @var StandardSpaceAttributes
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardSpaceAttributes::class)
     */
    public $attributes;

    /**
     * @var PropertyInventoryBookingReference
     * @ODM\EmbedOne(targetDocument=PropertyInventoryBookingReference::class)
     */
    public $bookingRef;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id'                 => $this->id,
            'spaceID'            => $this->spaceID,
            'baseChannelID'      => $this->baseChannelID,
            'connectedChannelID' => $this->connectedChannelID,
            'startDate'          => $this->startDate,
            'endDate'            => $this->endDate,
            'attributes'         => toArrayOrNull($this->attributes),
            'bookingRef'         => toArrayOrNull($this->bookingRef),
            'status'             => $this->status,
            'createdAt'          => $this->createdAt,
            'updatedAt'          => $this->updatedAt,
        ];
    }

    /**
     * User Repository
     *
     * @return PropertyInventoryRepository
     */
    public static function repository(): PropertyInventoryRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
