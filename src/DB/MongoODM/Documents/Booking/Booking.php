<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\MongoDBException;
use Illuminate\Support\Str;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails\BookingPaymentDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ApiLogReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\BrowserDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GSTDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Counter;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\BookingRepository;
use SYSOTEL\OTA\Common\Helpers\Enums;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="bookings",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\BookingRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class Booking extends Document
{
    use CanResolveIntegerID, HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'bookings';

    /**
     * @var int
     * @ODM\Id(strategy="CUSTOM", type="int", options={"class"=SYSOTEL\OTA\Common\DB\MongoODM\StorageStrategies\AutoIncrementID::class })
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $baseCurrency;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $secretToken;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $source;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $marketSegment;

    /**
     * @var ?UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $causer;

    /**
     * @var ?UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $guest;

    /**
     * @var ?BookingAgentDetails
     * @ODM\EmbedOne(targetDocument=BookingAgentDetails::class)
     */
    public $agent;

    /**
     * @var ?BookingCorporateUserDetails
     * @ODM\EmbedOne(targetDocument=BookingCorporateUserDetails::class)
     */
    public $corporateUser;

    /**
     * @var BookingPropertyReference
     * @ODM\EmbedOne(targetDocument=BookingPropertyReference::class)
     */
    public $property;

    /**
     * @var StayDates
     * @ODM\EmbedOne(targetDocument=StayDates::class)
     */
    public $stayDates;

    /**
     * @var BookingSpaceDetails
     * @ODM\EmbedOne(targetDocument=BookingSpaceDetails::class)
     */
    public $spaceDetails;

    /**
     * @var BookingGuestDetails
     * @ODM\EmbedOne(targetDocument=BookingGuestDetails::class)
     */
    public $guestDetails;

    /**
     * @var BookingContactDetails
     * @ODM\EmbedOne(targetDocument=BookingContactDetails::class)
     */
    public $contactDetails;

    /**
     * @var GSTDetails
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GSTDetails::class)
     */
    public $gstDetails;

    /**
     * @var BookingSpecialInstructions
     * @ODM\EmbedOne(targetDocument=BookingSpecialInstructions::class)
     */
    public $specialInstructions;

    /**
     * @var ?GuestCalculations
     * @ODM\EmbedOne (targetDocument=GuestCalculations::class)
     */
    public $guestCalculations;

    /**
     * @var ?PropertyCalculations
     * @ODM\EmbedOne (targetDocument=PropertyCalculations::class)
     */
    public $propertyCalculations;

    /**
     * @var BookingPaymentDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails\BookingPaymentDetails::class)
     */
    public $paymentDetails;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var BookingVoucher
     * @ODM\EmbedOne (targetDocument=BookingVoucher::class)
     */
    public $bookingVoucher;

    /**
     * @var ArrayCollection & BookingVoucherItem[]
     * @ODM\EmbedMany  (targetDocument=BookingVoucherItem::class)
     */
    public $bookingVouchers;

    /**
     * @var ArrayCollection & BookingRefund[]
     * @ODM\EmbedMany (targetDocument=BookingRefund::class)
     */
    public $refunds;

    /**
     * @var BookingCancellationDetails
     * @ODM\EmbedOne (targetDocument=BookingCancellationDetails::class)
     */
    public $cancellationDetails;

    /**
     * @var BookingPolicy
     * @ODM\EmbedOne (targetDocument=BookingPolicy::class)
     */
    public $policy;

    /**
     * @var ArrayCollection & InventoryUpdateLog[]
     * @ODM\EmbedMany (targetDocument=InventoryUpdateLog::class)
     */
    public $inventoryUpdates;

    /**
     * @var ?BrowserDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\BrowserDetails::class)
     */
    public $browserDetails;

    /**
     * @var ?BookingNoShowDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\BookingNoShowDetails::class)
     */
    public $noShowDetails;

    /**
     * @var ?BookingCheckInDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\BookingCheckInDetails::class)
     */
    public $checkInDetails;

    /**
     * @var ArrayCollection & ApiLogReference[]
     * @ODM\EmbedMany(targetDocument=ApiLogReference::class)
     */
    public $apiRefs;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->refunds = new ArrayCollection;
        $this->bookingVouchers = new ArrayCollection;
        $this->inventoryUpdates = new ArrayCollection;
        $this->apiRefs = new ArrayCollection();

        parent::__construct($attributes);
    }

    /**
     * @ODM\PrePersist
     */
    public function prePersist()
    {
        if (!$this->secretToken) {
            $this->secretToken = Str::random(6);
        }
    }

    /**
     * @param BookingCancellationDetails $cancellationDetails
     * @return $this
     */
    public function initiateCancellation(BookingCancellationDetails $cancellationDetails): static
    {
        $this->status = Enums::BOOKING_STATUS_CANCELLED;
        $this->cancellationDetails = $cancellationDetails;
        return $this;
    }

    /**
     * @return int
     * @throws MongoDBException
     */
    public static function generateNewBookingID(): int
    {
        $counter = Counter::queryBuilder()->findAndUpdate()->returnNew()
            ->field('_id')->equals('bookings')
            ->field('value')->inc(1)
            ->getQuery()->execute();

        return $counter->value;
    }

    public function spaceCountString(): string
    {
        $spaceCount = $this->spaceDetails->totalCount;
        $spaceText = ($spaceCount <= 1) ? 'Room' : 'Rooms';
        return $spaceCount . ' ' . $spaceText;
    }

    /**
     * @return null|GuestProfile
     */
    public function getPrimaryGuestProfile(): ?GuestProfile
    {
        foreach($this->guestDetails->profiles as $profile) {
            if($profile->isPrimary) {
                return $profile;
            }
        }

        return null;
    }

    /**
     * @param string $filePath
     * @param string $for
     * @param string $type
     * @param null $timestamp
     * @return self
     */
    public function addVoucher(string $filePath, string $for, string $type, $timestamp = null): self
    {
        if (!in_array($for, [BookingVoucherItem::FOR_GUEST, BookingVoucherItem::FOR_PROPERTY, BookingVoucherItem::FOR_AGENT])) {
            abort(500, 'Invalid value. $for - ' . $for);
        }

        if (!in_array($type, [BookingVoucherItem::TYPE_CONFIRMATION, BookingVoucherItem::TYPE_CANCELLATION])) {
            abort(500, 'Invalid value. $type - ' . $type);
        }

        $this->bookingVouchers->add(
            new BookingVoucherItem(compact('filePath', 'for', 'type', 'timestamp'))
        );

        return $this;
    }

    /**
     * @param string $for
     * @return BookingVoucherItem|null
     */
    public function getLatestBookingVoucher(string $for): ?BookingVoucherItem
    {
        if (!in_array($for, [BookingVoucherItem::FOR_GUEST, BookingVoucherItem::FOR_PROPERTY, BookingVoucherItem::FOR_AGENT])) {
            abort(500, 'Invalid value. $for - ' . $for);
        }

        return collect($this->bookingVouchers)
            ->sortByDate('timestamp', true)
            ->firstWhere('for', $for);
    }

    /**
     * @param BookingRefund $refund
     * @return $this
     */
    public function addRefund(BookingRefund $refund): static
    {
        $this->refunds->add($refund);
        return $this;
    }

    /**
     * @param string $id
     * @return BookingRefund|null
     */
    public function getRefundByID(string $id): ?BookingRefund
    {
        return collect($this->refunds)->firstWhere('id', $id);
    }

    /**
     * @param string $id
     * @param BookingRefund $targetRefund
     * @return $this|void
     */
    public function updateRefund(string $id, BookingRefund $targetRefund)
    {
        foreach ($this->refunds as $i => $refund) {
            if ($refund->id === $targetRefund->id) {
                $this->refunds[$i] = $targetRefund;
                return $this;
            }
        }

        abort(500, "No refund found with id $id");
    }

    /**
     * @return string
     */
    public function createRefundID(): string
    {
        if (!$this->bookingID) {
            abort(500, 'bookingID not set');
        }

        return 'refund_' . $this->bookingID . '_' . (count($this->refunds) + 1) . '_' . Str::random(5);
    }

    /**
     * @return bool
     */
    public function isGuestBooking(): bool
    {
        return $this->marketSegment === Enums::MARKET_SEGMENT_B2C;
    }

    /**
     * @return bool
     */
    public function isAgentBooking(): bool
    {
        return $this->marketSegment === Enums::MARKET_SEGMENT_B2B;
    }

    /**
     * @return static
     */
    public function generateSecretToken(): static
    {
        $this->secretToken = Str::random();
        return $this;
    }

    /**
     * @param int $paymentNo
     * @return string
     */
    public function generateNewBookingPaymentId(int $paymentNo): string
    {
        return 'tb' . $this->id . "no{$paymentNo}" . 'pid'  .$this->property->id;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'source' => $this->source,
            'marketSegment' => $this->marketSegment,
            'property' => toArrayOrNull($this->property),
            'stayDates' => toArrayOrNull($this->stayDates),
            'spaceDetails' => toArrayOrNull($this->spaceDetails),
            'guestDetails' => toArrayOrNull($this->guestDetails),
            'contactDetails' => toArrayOrNull($this->contactDetails),
            'guestCalculations' => toArrayOrNull($this->guestCalculations),
            'propertyCalculations' => toArrayOrNull($this->propertyCalculations),
            'bookingStatus' => $this->status,
            'bookingVoucher' => toArrayOrNull($this->bookingVoucher),
            'cancellationDetails' => toArrayOrNull($this->cancellationDetails),
            'browserDetails' => toArrayOrNull($this->browserDetails),
            'policy' => toArrayOrNull($this->policy),
            'noShowDetails' => toArrayOrNull($this->noShowDetails),
            'checkInDetails' => toArrayOrNull($this->checkInDetails),
            'createdAt' => $this->createdAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return BookingRepository
     */
    public static function repository(): BookingRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
