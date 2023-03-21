<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyRate;

use Delta4op\MongoODM\Documents\Document;
use Carbon\Carbon;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Arr;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyRateRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardProductAttributes;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="propertyRates",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyRateRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyRate extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyRates';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $productID;

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
     * @var StandardProductAttributes
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardProductAttributes::class)
     */
    public $attributes;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_SUCCESS = 'SUCCESS';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $tax;

    /**
     * Returns true if any configuration / mapping / linkage
     * was applied to this rate entry
     *
     * @return bool
     */
    public function hasConfiguration(): bool
    {
        return isset($this->hasConfiguration);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getSellRate(string $key): mixed
    {
        return $this->attributes->{$key}->sellRate ?? null;
    }

    /**
     * @return $this
     */
    public function markAsConfirmed(): static
    {
        $this->confirmedAt = now();

        return $this;
    }

    /**
     * @param ObjectId|string|string[]|ObjectId[] $ids
     */
    public function addChannelLogIDs(ObjectId|string|array $ids): static
    {
        foreach(Arr::wrap($ids) as $id) {

            $id = is_string($id) ? new ObjectId($id) : $id;

            $this->channelLogIDs[] = $id;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'                 => $this->id,
            'productID'          => $this->productID,
            'baseChannelID'      => $this->baseChannelID,
            'connectedChannelID' => $this->connectedChannelID,
            'startDate'          => $this->startDate,
            'endDate'            => $this->endDate,
            'attributes'         => $this->attributes->toArray(),
            'status'             => $this->status,
            'createdAt'          => $this->createdAt,
            'updatedAt'          => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyRateRepository
     */
    public static function repository(): PropertyRateRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
