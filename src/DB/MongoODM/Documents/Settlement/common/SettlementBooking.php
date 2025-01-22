<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\Booking;

/**
 * @ODM\EmbeddedDocument
 */
class SettlementBooking extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $bookingID;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkIn;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkInDate;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkOut;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkOutDate;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAtDate;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $paymentMode;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $guestID;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $primaryGuestFullName;

    public static function createFromBooking(Booking $booking): SettlementBooking {
        $settlementBooking = new self;
        $settlementBooking->bookingID = $booking->id;
        $settlementBooking->checkIn = $booking->stayDates->checkIn;
        $settlementBooking->checkInDate = $booking->stayDates->checkInDate;
        $settlementBooking->checkOut = $booking->stayDates->checkOut;
        $settlementBooking->checkOutDate = $booking->stayDates->checkOutDate;
        $settlementBooking->createdAtDate = $booking->createdAt->startOfDay();
        $settlementBooking->createdAt = $booking->createdAt;
        $settlementBooking->paymentMode = $booking->paymentDetails->paymentMode;
        $settlementBooking->status = $booking->status;
        $settlementBooking->guestID = $booking->guest?->id;
        $settlementBooking->primaryGuestFullName = $booking->guestDetails->getPrimaryGuestProfile()->fullName;

        return $settlementBooking;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
