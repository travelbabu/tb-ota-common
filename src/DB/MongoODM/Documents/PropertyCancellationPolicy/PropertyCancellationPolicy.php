<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCancellationPolicy;

use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasDeletedAt;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyCancellationPolicyRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="propertyCancellationPolicies",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyCancellationPolicyRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyCancellationPolicy extends EmbeddedDocument
{
    use HasTimestamps, HasDeletedAt, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyCancellationPolicies';

    /**
     * @var ObjectId
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $freeCancellationBefore;

    /**
     * @var ArrayCollection & CancellationRule[]
     * @ODM\EmbedMany(targetDocument=CancellationRule::class)
     */
    public $rules;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_DISABLED = 'DISABLED';
    public const STATUS_EXPIRED = 'EXPIRED';
    public const STATUS_DELETED = 'DELETED';


    public $defaults = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->rules = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @return array
     */
    public function descriptionArray(): array
    {
        $arr = [];

        $arr[] = '100 percent cancellation charges will be levied if cancelled after checkin date or on No show';
        $arr[] = 'FREE cancellation if cancelled before ' . $this->freeCancellationBefore / 24 . ' days from the check in date';

        foreach($this->rules as $rule) {
            $arr[] = $rule->description();
        }

        return $arr;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'       => $this->id,
            'propertyID' => $this->propertyID,
            'freeCancellationBefore' => $this->freeCancellationBefore,
            'status'   => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'deletedAt' => $this->deletedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyCancellationPolicyRepository
     */
    public static function repository(): PropertyCancellationPolicyRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
