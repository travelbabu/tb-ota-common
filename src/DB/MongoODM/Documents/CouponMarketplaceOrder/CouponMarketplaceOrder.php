<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CouponMarketplaceOrder;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\DateRange;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="couponMarketplaceOrders"
 * )
 * @ODM\HasLifecycleCallbacks
 */
class CouponMarketplaceOrder extends Document
{
    use HasTimestamps, HasRepository;

    /**
     * @inheritdoc
     */
    protected string $collection = 'couponMarketplaceOrders';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $user;

    /**
     * @var ArrayCollection & PurchaseItem[]
     * @ODM\EmbedMany (targetDocument=PurchaseItem::class)
     */
    public $purchaseItems;

    /**
     * @var PaymentDetails
     * @ODM\EmbedOne (targetDocument=PaymentDetails::class)
     */
    public $paymentDetails;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ATTEMPT = 'ATTEMPT';
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_FAILURE = 'FAILURE';

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;

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
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->purchaseItems = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
