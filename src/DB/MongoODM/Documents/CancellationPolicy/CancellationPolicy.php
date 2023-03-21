<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CancellationPolicyRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy\Types\Custom\CustomCancellationPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy\Types\Standard\StandardCancellationPolicy;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *  collection="propertyCancellationPolicies",
 *  repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CancellationPolicyRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class CancellationPolicy extends Document
{
    use HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyCancellationPolicies';

    public const TYPE_STANDARD = 'STANDARD';
    public const TYPE_CUSTOM = 'CUSTOM';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $spaceID;

    /**
     * @var PolicyValidity
     * @ODM\EmbedOne(targetDocument=PolicyValidity::class)
     */
    public $validity;

    /**
     * @var StandardCancellationPolicy|CustomCancellationPolicy
     * @ODM\EmbedOne(
     *   discriminatorField="type",
     *   discriminatorMap={
     *     "STANDARD"=Types\Standard\StandardCancellationPolicy::class,
     *     "CUSTOM"=Types\Standard\CustomCancellationPolicy::class
     *   }
     * )
     */
    public $details;

    /**
     * @var string
     * @ODM\Field (type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_DELETED = 'DELETED';

    /**
     * @var Carbon
     * @ODM\Field (type="carbon")
     */
    public $deletedAt;

    protected $defaults = [
        'status' => self::STATUS_ACTIVE
    ];

    /**
     * @return $this
     */
    public function markAsDeleted(): static
    {
        $this->status = self::STATUS_DELETED;
        $this->deletedAt = now();

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'          => $this->id,
            'name'        => $this->name,
            'propertyID'  => $this->propertyID,
            'spaceID'     => $this->spaceID,
            'type'        => $this->type,
            'validity'    => toArrayOrNull($this->validity),
            'details'     => toArrayOrNull($this->details),
            'status'      => $this->status,
            'createdAt'   => $this->createdAt,
            'updatedAt'   => $this->updatedAt,
            'deletedAt'   => $this->deletedAt,
        ]);
    }

    /**
     * @return CancellationPolicyRepository
     */
    public static function repository(): CancellationPolicyRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
