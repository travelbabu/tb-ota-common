<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\Booking;
use SYSOTEL\OTA\Common\Helpers\Enums;

use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

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
     * @var ?Carbon
     * @ODM\Field(type="carbon")
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

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $bookingAmount;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $commission;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $commissionPercentage;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $commissionTax;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $commissionTaxPercentage;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $totalCommission;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $tds;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $tdsPercentage;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $tcs;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $tcsPercentage;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $otaToPropertyPayable;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $prepaidAmount;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $payAtPropertyAmount;

    /**
     * @var ?boolean
     * @ODM\Field(type="boolean")
     */
    public $isOtaPayable;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $settlementAmount;

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
        $settlementBooking->bookingAmount = $booking->propertyCalculations->spaceCharges->amountAfterTax;
        $settlementBooking->commission = $booking->propertyCalculations->spaceCharges->otaCommission->amount;
        $settlementBooking->commissionPercentage = $booking->propertyCalculations->spaceCharges->otaCommission->percentage;
        $settlementBooking->commissionTax = $booking->propertyCalculations->spaceCharges->otaCommission->tax;
        $settlementBooking->totalCommission = $booking->propertyCalculations->spaceCharges->amountAfterOtaCommission;
        $settlementBooking->tds = $booking->propertyCalculations->tds ?? 0;
        $settlementBooking->tdsPercentage = $booking->propertyCalculations->tdsPercentage ?? 0;
        $settlementBooking->tcs = $booking->propertyCalculations->tcs ?? 0;
        $settlementBooking->tcsPercentage = $booking->propertyCalculations->tcsPercentage ?? 0;
        $settlementBooking->otaToPropertyPayable = $booking->propertyCalculations->otaToPayPropertyAmount;
        

        if($booking->paymentDetails->paymentMode === Enums::PAYMENT_MODE_PAY_NOW) {
            $settlementBooking->prepaidAmount = $settlementBooking->bookingAmount;
            $settlementBooking->payAtPropertyAmount = 0;
        } else if($booking->paymentDetails->paymentMode === Enums::PAYMENT_MODE_PAY_AT_PROPERTY) {
            $settlementBooking->prepaidAmount = 0;
            $settlementBooking->payAtPropertyAmount = $settlementBooking->bookingAmount;
        } else {
            // todo
        }

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
