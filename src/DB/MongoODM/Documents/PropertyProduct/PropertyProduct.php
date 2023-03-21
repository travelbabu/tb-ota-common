<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct;

use Carbon\Carbon;
use \Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\TgrDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyProductRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="propertyProducts",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyProductRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyProduct extends Document
{
    use CanResolveIntegerID, HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyProducts';

    /**
     * @inheritdoc
     */
    protected string $keyType = 'int';

    /**
     * @var int
     * @ODM\Id(strategy="CUSTOM", type="int", options={"class"=SYSOTEL\OTA\Common\DB\MongoODM\StorageStrategies\AutoIncrementID::class })
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID;

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
     * Counter value
     *
     * @var string
     * @ODM\Field(type="string")
     */
    public $displayName;

    /**
     * Counter value
     *
     * @var string
     * @ODM\Field(type="string")
     */
    public $internalName;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    public $description;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentMode;
    public const PAYMENT_MODE_PAY_NOW = 'PAY_NOW';
    public const PAYMENT_MODE_PAY_AT_PROPERTY = 'PAY_AT_PROPERTY';
    public const PAYMENT_MODE_PAY_PARTIAL = 'PAY_PARTIAL';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $mealPlanCode;
    public const MEAL_PLAN_CODE_EP = 'EP';
    public const MEAL_PLAN_CODE_CP = 'CP';
    public const MEAL_PLAN_CODE_MAP = 'MAP';
    public const MEAL_PLAN_CODE_AP = 'AP';

    /**
     * @var string[]
     * @ODM\Field(type="collection")
     */
    public $inclusions = [];

    /**
     * @var PartialPayment
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment::class)
     */
    public $partialPayment;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_DISABLED = 'DISABLED';
    public const STATUS_DELETED = 'DELETED';

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $sortOrder;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $lowerPriceThreshold;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $upperPriceThreshold;

    /**
     * @var TgrDetails
     * @ODM\EmbedOne(targetDocument=TgrDetails::class)
     */
    public $tgrDetails;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $deletedAt;

    /**
     * @ODM\PrePersist
    */
    public function setInclusions()
    {
        $this->inclusions = array_merge($this->inclusions, match($this->mealPlanCode){
            self::MEAL_PLAN_CODE_CP => ['FREE Breakfast'],
            self::MEAL_PLAN_CODE_MAP => ['FREE Breakfast', 'FREE Lunch or Dinner'],
            self::MEAL_PLAN_CODE_AP => ['All Meals FREE'],
            default => []
        });
    }

    public $defaults = [
        'supplierID' => Supplier::ID_SELF,
        'status' => self::STATUS_ACTIVE,
        'sortOrder' => 0,
    ];

    /**
     * @return $this
     */
    public function markAsDisabled(): self
    {
        $this->status = self::STATUS_DISABLED;
        return $this;
    }

    /**
     * @return $this
     */
    public function markAsDeleted(): self
    {
        $this->status = self::STATUS_DELETED;
        $this->deletedAt = now();
        return $this;
    }

    /**
     * @return $this
     */
    public function markAsActive(): self
    {
        $this->status = self::STATUS_ACTIVE;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'                   => $this->id,
            'propertyID'           => $this->propertyID,
            'spaceID'              => $this->spaceID,
            'displayName'          => $this->displayName,
            'internalName'         => $this->internalName,
            'description'          => $this->description,
            'mealPlanCode'         => $this->mealPlanCode,
            'lowerPriceThreshold'  => $this->lowerPriceThreshold,
            'upperPriceThreshold'  => $this->upperPriceThreshold,
            'tgrDetails'           => toArrayOrNull($this->tgrDetails),
            'status'               => $this->status,
            'createdAt'            => $this->createdAt,
            'updatedAt'            => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyProductRepository
     */
    public static function repository(): PropertyProductRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
