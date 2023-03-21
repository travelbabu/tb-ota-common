<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Coupon;

use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\DateRange;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CouponRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="coupons",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CouponRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({
 *     "TIME_BASED":SYSOTEL\OTA\Common\DB\MongoODM\Documents\Coupon\TimeBased\TimeBasedCoupon::class,
 *     "DIRECT_DISCOUNT":SYSOTEL\OTA\Common\DB\MongoODM\Documents\Coupon\DirectDiscount\DirectDiscountCoupon::class,
 *     "SERVICE_CHARGE_FRIENDLY":SYSOTEL\OTA\Common\DB\MongoODM\Documents\Coupon\ServiceChargeFriendly\ServiceChargeFriendlyCoupon::class
 * })
 */
class Coupon extends EmbeddedDocument
{
    use HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'coupons';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $userID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $code;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $tagline;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $description;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $terms;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isLoginRequired;

    /**
     * @var string[]
     * @ODM\Field(type="collection")
     */
    public $userTypes;

    /**
     * @var DateRange
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\DateRange::class)
     */
    public $stayDateValidity;

    /**
     * @var DateRange
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\DateRange::class)
     */
    public $bookingDateValidity;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isActive;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $useLimit;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $useCount;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $bookingIDs;

    protected $defaults = [
        'isActive' => true,
        'useCount' => 0,
        'bookingIDs' => []
    ];

    public function incrementUseCount(int $bookingID): self
    {
        $this->bookingIDs[] = $bookingID;

        $this->useCount++;
        if($this->useLimit) {
            if($this->useCount >= $this->useLimit) {
                $this->isActive = false;
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }

    /**
     * @return CouponRepository
     */
    public static function repository(): CouponRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
