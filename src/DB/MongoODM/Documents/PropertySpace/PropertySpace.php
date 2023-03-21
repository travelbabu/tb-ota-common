<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\PropertyAvatar;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertySpaceRepository;
use SYSOTEL\OTA\Common\Services\ImageServices\Facades\ImageStorageManager;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="propertySpaces",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertySpaceRepository::class
 * ),
 * @ODM\HasLifecycleCallbacks
 */
class PropertySpace extends Document
{
    use CanResolveIntegerID, HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertySpaces';

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
     * @var string
     * @ODM\Field(type="string")
     */
    public $displayName;

    /**
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
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $noOfUnits;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $baseOccupancy;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $maxOccupancy;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $maxExtraBeds;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isChildAllowed;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $supportedRates;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $lowerRateThreshold;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $upperRateThreshold;

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
     * @var TgrDetails
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\TgrDetails::class)
     */
    public $tgrDetails;

    /**
     * @var SpaceView
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\SpaceView::class)
     */
    public $view;

    /**
     * @var ?SpaceAvatar
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\SpaceAvatar::class)
     */
    public $avatar;

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
     * @var array
     */
    public $defaults = [
        'supplierID' => Supplier::ID_SELF,
        'status' => self::STATUS_ACTIVE,
        'sortOrder' => 0,
        'isChildAllowed' => true,
    ];

    /**
     * @param PropertyImage $image
     */
    public function setAvatar(PropertyImage $image)
    {
        $this->avatar = new SpaceAvatar([
            'filePath' => $image->filePath
        ]);
    }

    /**
     * Calculates supported rates based on occupancy fields
     * @ODM\PrePersist
     */
    public function markSupportedRates(): static
    {
        $supportedRates = [];

        foreach([1 => 'singleRate', 2 => 'doubleRate', 3 => 'tripleRate', 4 => 'quadRate'] as $n => $rate) {

            if($n >= $this->baseOccupancy && $n <= ($this->maxOccupancy - $this->maxExtraBeds)) {
                $supportedRates[] = $rate;
            }
        }

        if($this->maxExtraBeds > 0) {
            $supportedRates[] = 'extraAdultRate';
            $supportedRates[] = 'extraChildRate';
        }

        $this->supportedRates = $supportedRates;

        return $this;
    }

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $deletedAt;

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
     * @ODM\PrePersist
     */
    public function prePersist()
    {
        $this->markSupportedRates();
    }

    /**
     * @ODM\PreUpdate
     */
    public function preUpdate()
    {
        $this->markSupportedRates();
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'                  => $this->id,
            'propertyID'          => $this->propertyID,
            'displayName'         => $this->displayName,
            'internalName'        => $this->internalName,
            'description'         => $this->description,
            'noOfUnits'           => $this->noOfUnits,
            'baseOccupancy'       => $this->baseOccupancy,
            'maxOccupancy'        => $this->maxOccupancy,
            'maxExtraBeds'        => $this->maxExtraBeds,
            'isChildAllowed'      => $this->isChildAllowed,
            'supportedRates'      => $this->supportedRates,
            'lowerPriceThreshold' => $this->lowerPriceThreshold,
            'upperPriceThreshold' => $this->upperPriceThreshold,
            'view'                => toArrayOrNull($this->view),
            'avatar'              => toArrayOrNull($this->avatar),
            'tgrDetails'          => toArrayOrNull($this->tgrDetails),
            'status'              => $this->status,
            'createdAt'           => $this->createdAt,
            'updatedAt'           => $this->updatedAt,
        ]);
    }

    /**
     * @return PropertySpaceRepository
     */
    public static function repository(): PropertySpaceRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
