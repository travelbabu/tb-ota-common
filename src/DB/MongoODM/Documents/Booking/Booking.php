<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\MongoDBException;
use Illuminate\Support\Str;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails\BookingPaymentDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GSTDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Counter;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\BookingRepository;
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
    use HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'bookings';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $secretToken;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $bookingID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $version;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierBookingID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $source;
    public const SOURCE_B2C_PORTAL = 'B2C_PORTAL';
    public const SOURCE_AGENT_PORTAL = 'AGENT_PORTAL';
    public const SOURCE_CORPORATE_PORTAL = 'CORPORATE_PORTAL';

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $guestID;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isSelfBooking;

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
    public $agentDetails;

    /**
     * @var ?BookingCorporateUserDetails
     * @ODM\EmbedOne(targetDocument=BookingCorporateUserDetails::class)
     */
    public $corporateUserDetails;

    /**
     * @var PropertyReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyReference::class)
     */
    public $property;

    /**
     * @var StayDates
     * @ODM\EmbedOne(targetDocument=StayDates::class)
     */
    public $stayDates;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $noOfSpaces;

    /**
     * @var GuestCount
     * @ODM\EmbedOne(targetDocument=GuestCount::class)
     */
    public $totalGuestCount;

    /**
     * @var BookingContactDetails
     * @ODM\EmbedOne(targetDocument=BookingContactDetails::class)
     */
    public $contactDetails;

    /**
     * @var ArrayCollection & GuestProfile[]
     * @ODM\EmbedMany (targetDocument=GuestProfile::class)
     */
    public $guestList;

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
     * @var Bill
     * @ODM\EmbedOne (targetDocument=Bill::class)
     */
    public $bill;

//    /**
//     * @var GuestPaymentDetails
//     * @ODM\EmbedOne (targetDocument=GuestPaymentDetails::class)
//     */
//    public $guestPaymentDetails;

    /**
     * @var BookingPaymentDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails\BookingPaymentDetails::class)
     */
    public $paymentDetails;

    /**
     * @var BookingStatus
     * @ODM\EmbedOne(targetDocument=BookingStatus::class)
     */
    public $bookingStatus;

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
     * @var ArrayCollection & InventoryUpdateLog[]
     * @ODM\EmbedMany (targetDocument=InventoryUpdateLog::class)
     */
    public $inventoryUpdates;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isActive;

    protected $defaults = [
        'version' => 1,
        'isActive' => true
    ];

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->refunds = new ArrayCollection;
        $this->guestList = new ArrayCollection;
        $this->bookingVouchers = new ArrayCollection;
        $this->inventoryUpdates = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @ODM\PrePersist
     */
    public function prePersist()
    {
        if(!$this->secretToken) {
            $this->secretToken = Str::random(6);
        }
    }

    /**
     * @param BookingCancellationDetails $cancellationDetails
     * @return $this
     */
    public function initiateCancellation(BookingCancellationDetails $cancellationDetails): static
    {
        $this->bookingStatus->status = BookingStatus::STATUS_CANCELLED;
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
        $spaceCount = $this->noOfSpaces ?? 0;
        $spaceText = ($spaceCount <= 1) ? 'Room' : 'Rooms';
        return $spaceCount . ' ' . $spaceText;
    }

    /**
     * @return null|GuestProfile
     */
    public function getPrimaryGuestProfile(): ?GuestProfile
    {
        return collect($this->guestList)->firstWhere('isPrimaryGuest', true);
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
        if(!in_array($for, [BookingVoucherItem::FOR_GUEST, BookingVoucherItem::FOR_PROPERTY, BookingVoucherItem::FOR_AGENT])) {
            abort(500, 'Invalid value. $for - ' . $for);
        }

        if(!in_array($type, [BookingVoucherItem::TYPE_CONFIRMATION, BookingVoucherItem::TYPE_CANCELLATION])) {
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
        if(!in_array($for, [BookingVoucherItem::FOR_GUEST, BookingVoucherItem::FOR_PROPERTY, BookingVoucherItem::FOR_AGENT])) {
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
        foreach($this->refunds as $i => $refund) {
            if($refund->id === $targetRefund->id) {
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
        if(!$this->bookingID) {
            abort(500, 'bookingID not set');
        }

        return 'refund_' . $this->bookingID . '_' . (count($this->refunds) + 1) . '_' . Str::random(5);
    }

    /**
     * @return bool
     */
    public function isGuestBooking(): bool
    {
        return $this->source === self::SOURCE_B2C_PORTAL;
    }

    /**
     * @return bool
     */
    public function isAgentBooking(): bool
    {
        return $this->source === self::SOURCE_AGENT_PORTAL;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'                   => $this->id,
            'bookingID'            => $this->bookingID,
            'supplierBookingID'    => $this->supplierBookingID,
            'supplierID'           => $this->supplierID,
            'property'             => toArrayOrNull($this->property),
            'stayDates'            => toArrayOrNull($this->stayDates),
            'totalGuestCount'      => toArrayOrNull($this->totalGuestCount),
            'contactDetails'       => toArrayOrNull($this->contactDetails),
            'guestList'            => collect($this->guestList)->toArray(),
            'bookingProperty'      => toArrayOrNull($this->bookingProperty),
            'bill'                 => toArrayOrNull($this->bill),
            'guestPaymentDetails'  => toArrayOrNull($this->guestPaymentDetails),
            'bookingStatus'        => toArrayOrNull($this->bookingStatus),
            'bookingVoucher'       => toArrayOrNull($this->bookingVoucher),
            'cancellationDetails'  => toArrayOrNull($this->cancellationDetails),
            'isActive'             => $this->isActive,
            'createdAt'            => $this->createdAt,
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
