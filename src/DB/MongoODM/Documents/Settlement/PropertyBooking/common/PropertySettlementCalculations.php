<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\PropertyBooking\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\Booking;
use SYSOTEL\OTA\Common\Helpers\Enums;

/**
 * @ODM\EmbeddedDocument
 */
class PropertySettlementCalculations extends EmbeddedDocument
{
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

    public static function createFromBooking(Booking $booking): PropertySettlementCalculations {
        $calculations = new self;
        
        $calculations->bookingAmount = $booking->propertyCalculations->spaceCharges->amountAfterTax;
        $calculations->commission = $booking->propertyCalculations->spaceCharges->otaCommission->amount;
        $calculations->commissionPercentage = $booking->propertyCalculations->spaceCharges->otaCommission->percentage;
        $calculations->commissionTax = $booking->propertyCalculations->spaceCharges->otaCommission->tax->amount;
        $calculations->totalCommission = $booking->propertyCalculations->spaceCharges->amountAfterOtaCommission;
        $calculations->tds = $booking->propertyCalculations->tds ?? 0;
        $calculations->tdsPercentage = $booking->propertyCalculations->tdsPercentage ?? 0;
        $calculations->tcs = $booking->propertyCalculations->tcs ?? 0;
        $calculations->tcsPercentage = $booking->propertyCalculations->tcsPercentage ?? 0;
        $calculations->otaToPropertyPayable = $booking->propertyCalculations->otaToPayPropertyAmount;
        

        if($booking->paymentDetails->paymentMode === Enums::PAYMENT_MODE_PAY_NOW) {
            $calculations->prepaidAmount = $calculations->bookingAmount;
            $calculations->payAtPropertyAmount = 0;
        } else if($booking->paymentDetails->paymentMode === Enums::PAYMENT_MODE_PAY_AT_PROPERTY) {
            $calculations->prepaidAmount = 0;
            $calculations->payAtPropertyAmount = $calculations->bookingAmount;
        } else {
            // todo
        }

        return $calculations;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
