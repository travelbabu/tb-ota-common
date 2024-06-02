<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyRestrictions;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Delta4op\MongoODM\Facades\DocumentManager;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyRestrictionsRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardRestrictionAttributes;

/**
 * @ODM\Document(
 *     collection="propertyRestrictions",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyRestrictionsRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyRestrictions extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyRestrictions';

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
     * @var StandardRestrictionAttributes
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardRestrictionAttributes::class)
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
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'productID' => $this->productID,
            'baseChannelID' => $this->baseChannelID,
            'connectedChannelID' => $this->connectedChannelID,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'attributes' => $this->attributes->toArray(),
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyRestrictionsRepository
     */
    public static function repository(): PropertyRestrictionsRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
