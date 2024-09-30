<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\embedded\PromotionApplicableSpaceDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PromotionsRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="promotions",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PromotionsRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({
 *     "BASIC":SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\types\BasicPromotion::class,
 *     "LAST_MINUTE":SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\types\LastMinutePromotion::class,
 *     "EARLY_BIRD":SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\types\EarlyBirdPromotion::class,
 * })
 */
class Promotion extends Document
{
    use HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'promotions';

    /**
     * @var ?string
     * @ODM\Id
     */
    public $id;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $category;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $promoID;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $promoCode;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $internalName;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $displayName;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $visibility;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $applicableOn;
    public const APPLICABLE_ON_SPACE_BASE_AMOUNT = 'SPACE_BASE_AMOUNT';
    public const APPLICABLE_ON_SPACE_FINAL_AMOUNT = 'SPACE_FINAL_AMOUNT';

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_EXPIRED = 'EXPIRED';

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $dateRestrictionType;
    public const DATE_RESTRICTION_TYPE_STAY_DATE = 'STAY_DATE';
    public const DATE_RESTRICTION_TYPE_STAY_DATE_BOOKING_DATE = 'STAY_DATE_BOOKING_DATE';

    /**
     * @var ?bool
     * @ODM\Field(type="bool")
     */
    public $isExpired;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $bookingStartDate;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $bookingEndDate;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $stayStartDate;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $stayEndDate;

    /**
     * @var ?PromotionApplicableSpaceDetails
     * @ODM\EmbedOne (targetDocument=PromotionApplicableSpaceDetails::class)
     */
    public $applicableSpaceDetails;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    protected $expiredAt;

    public $defaults = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * @param int $productID
     * @return bool
     */
    public function isProductApplicable(int $productID): bool
    {
        foreach (($this->applicableSpaceDetails?->applicableSpaces ?? []) as $applicableSpace) {
            foreach (($applicableSpace->applicableProducts ?? []) as $applicableProduct) {
                if ($applicableProduct->productID === $productID) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param int $spaceID
     * @return bool
     */
    public function isSpaceApplicableWithAllProducts(int $spaceID): bool
    {
        foreach (($this->applicableSpaceDetails?->applicableSpaces ?? []) as $applicableSpace) {
            if ($applicableSpace->spaceID === $spaceID && $applicableSpace->applicableOnAllProducts) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int $spaceID
     * @return bool
     */
    public function isSpaceApplicable(int $spaceID): bool
    {
        foreach (($this->applicableSpaceDetails?->applicableSpaces ?? []) as $applicableSpace) {
            if ($applicableSpace->spaceID === $spaceID) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getPromoID(): ?int
    {
        return $this->promoID;
    }

    /**
     * @param int|null $promoID
     */
    public function setPromoID(?int $promoID): void
    {
        $this->promoID = $promoID;
    }

    /**
     * @return int|null
     */
    public function getPropertyID(): ?int
    {
        return $this->propertyID;
    }

    /**
     * @param int|null $propertyID
     */
    public function setPropertyID(?int $propertyID): void
    {
        $this->propertyID = $propertyID;
    }

    /**
     * @return string|null
     */
    public function getInternalName(): ?string
    {
        return $this->internalName;
    }

    /**
     * @param string|null $internalName
     */
    public function setInternalName(?string $internalName): void
    {
        $this->internalName = $internalName;
    }

    /**
     * @return string|null
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * @param string|null $displayName
     */
    public function setDisplayName(?string $displayName): void
    {
        $this->displayName = $displayName;
    }

    /**
     * @return bool|null
     */
    public function isExpired(): ?bool
    {
        return $this->isExpired;
    }

    /**
     * @param bool|null $isExpired
     */
    public function setIsExpired(?bool $isExpired): void
    {
        $this->isExpired = $isExpired;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getDateRestrictionType(): ?string
    {
        return $this->dateRestrictionType;
    }

    /**
     * @param string|null $dateRestrictionType
     */
    public function setDateRestrictionType(?string $dateRestrictionType): void
    {
        $this->dateRestrictionType = $dateRestrictionType;
    }

    /**
     * @return Carbon|null
     */
    public function getBookingStartDate(): ?Carbon
    {
        return $this->bookingStartDate;
    }

    /**
     * @param Carbon|null $bookingStartDate
     */
    public function setBookingStartDate(?Carbon $bookingStartDate): void
    {
        $this->bookingStartDate = $bookingStartDate;
    }

    /**
     * @return Carbon|null
     */
    public function getBookingEndDate(): ?Carbon
    {
        return $this->bookingEndDate;
    }

    /**
     * @param Carbon|null $bookingEndDate
     */
    public function setBookingEndDate(?Carbon $bookingEndDate): void
    {
        $this->bookingEndDate = $bookingEndDate;
    }

    /**
     * @return Carbon|null
     */
    public function getStayStartDate(): ?Carbon
    {
        return $this->stayStartDate;
    }

    /**
     * @param Carbon|null $stayStartDate
     */
    public function setStayStartDate(?Carbon $stayStartDate): void
    {
        $this->stayStartDate = $stayStartDate;
    }

    /**
     * @return Carbon|null
     */
    public function getStayEndDate(): ?Carbon
    {
        return $this->stayEndDate;
    }

    /**
     * @param Carbon|null $stayEndDate
     */
    public function setStayEndDate(?Carbon $stayEndDate): void
    {
        $this->stayEndDate = $stayEndDate;
    }

    /**
     * @return Carbon|null
     */
    public function getExpiredAt(): ?Carbon
    {
        return $this->expiredAt;
    }

    /**
     * @param Carbon|null $expiredAt
     */
    public function setExpiredAt(?Carbon $expiredAt): void
    {
        $this->expiredAt = $expiredAt;
    }

    /**
     * @return PromotionsRepository
     */
    public static function repository(): PromotionsRepository
    {
        return DocumentManager::getRepository(self::class);
    }

    public function getStayDateValidityString()
    {
        if(!$this->stayStartDate && !$this->stayEndDate) {
            return 'Valid Forever';
        }

        if($this->stayStartDate && !$this->stayEndDate) {
            return "From {$this->stayStartDate->format('d M Y')}";
        }

        if(!$this->stayStartDate && $this->stayEndDate) {
            return "Till {$this->stayEndDate->format('d M Y')}";
        }

        if($this->stayEndDate && $this->stayStartDate) {
            return "{$this->stayStartDate->format('d M Y')} to {$this->stayEndDate->format('d M Y')}";
        }
    }

    public function getBookingDateValidityString()
    {
        if(!$this->bookingStartDate && !$this->bookingEndDate) {
            return 'Valid Forever';
        }

        if($this->bookingStartDate && !$this->bookingEndDate) {
            return "From {$this->bookingStartDate->format('d M Y')}";
        }

        if(!$this->bookingStartDate && $this->bookingEndDate) {
            return "Till {$this->bookingEndDate->format('d M Y')}";
        }

        if($this->bookingEndDate && $this->bookingStartDate) {
            return "{$this->bookingStartDate->format('d M Y')} to {$this->bookingEndDate->format('d M Y')}";
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
