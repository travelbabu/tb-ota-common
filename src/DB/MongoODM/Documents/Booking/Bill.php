<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment;

/**
 * @ODM\EmbeddedDocument
 */
class Bill extends EmbeddedDocument
{
    public const DEFAULT_PRECISION = 2;
    public const GUEST_AMOUNT_PRECISION = 0;

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $cancellationPolicyID;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $cancellationPolicyText;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $currencyCode;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentMode;
    public const PAYMENT_MODE_PAY_NOW = 'PAY_NOW';
    public const PAYMENT_MODE_PAY_AT_PROPERTY = 'PAY_AT_PROPERTY';
    public const PAYMENT_MODE_PAY_PARTIAL = 'PAY_PARTIAL';

    /**
     * @var PartialPayment
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment::class)
     */
    public $partialPayment;

    /**
     * @var ArrayCollection & BookingSpace[]
     * @ODM\EmbedMany(targetDocument=BookingSpace::class)
     */
    public $bookingSpaces;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $baseCharges = 0; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $extraAdultCharges = 0; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $extraChildCharges = 0; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $extraGuestCharges = 0; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $spaceCharges = 0; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $propertyDiscount = 0; // AC

    /**
     * @var ArrayCollection & PropertyDiscountItem[]
     * @ODM\EmbedMany(targetDocument=PropertyDiscountItem::class)
     */
    public $propertyDiscountItems = 0; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $propertySellPrice = 0; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $propertyTax = 0; // AC

    /**
     * @var ArrayCollection & TaxItem[]
     * @ODM\EmbedMany(targetDocument=TaxItem::class)
     */
    public $propertyTaxItems; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $propertyGrossCharges = 0; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaDiscount = 0;

    /**
     * @var ArrayCollection & OtaDiscountItem[]
     * @ODM\EmbedMany(targetDocument=OtaDiscountItem::class)
     */
    public $otaDiscountItems;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $chargesAfterAllDiscounts = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaServiceCharges = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaServiceChargePercentage = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaServiceChargeTax = 0;

    /**
     * @var ArrayCollection & TaxItem[]
     * @ODM\EmbedMany(targetDocument=TaxItem::class)
     */
    public $otaServiceChargeTaxItems;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $finalOtaServiceCharges = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $guestPayableAmount; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $guestPayNowAmount; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $guestPayLaterAmount; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaCommission = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaCommissionPercentage;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaCommissionTax = 0;

    /**
     * @var ArrayCollection & TaxItem[]
     * @ODM\EmbedMany(targetDocument=TaxItem::class)
     */
    public $otaCommissionTaxItems;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $finalOtaCommission = 0;

    /**
     * @var AffiliateCommission
     * @ODM\EmbedOne (targetDocument=AffiliateCommission::class)
     */
    public $affiliateCommission;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $tds; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $tdsPercentage = 1;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $tcs; // AC

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $tcsPercentage = 1;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaToPayPropertyAmount;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $taxAndCharges = 0;

    public function calculate()
    {
        // set ota commission
        // set OTA discount
        // set ota service charge before hitting this

        $this->baseCharges = 0;
        $this->extraGuestCharges = 0;
        $this->extraAdultCharges = 0;
        $this->extraChildCharges = 0;
        $this->propertyDiscount = 0;
        $this->propertyTax = 0;
        $this->propertyTaxItems = new ArrayCollection;
        $this->spaceCharges = 0;
        $this->propertySellPrice = 0;
        $this->propertyGrossCharges = 0;
        $this->otaCommission = 0;
        $this->otaCommissionTax = 0;
        $this->finalOtaCommission = 0;
        $this->otaCommissionPercentage = null;
        $this->otaCommissionTaxItems = new ArrayCollection;

        $this->affiliateCommission = null;
        // values that should be calculated
        foreach($this->bookingSpaces as $bookingSpace) {
            foreach($bookingSpace->dailyCalculations as $dailyCalculation) {

                // SPACE CHARGES TYPES
                $this->baseCharges += $dailyCalculation->baseCharges;
                $this->extraGuestCharges += $dailyCalculation->extraGuestCharges;
                $this->extraAdultCharges += $dailyCalculation->extraAdultCharges;
                $this->extraChildCharges += $dailyCalculation->extraChildCharges;

                // TOTAL SPACE CHARGES
                $this->spaceCharges += $dailyCalculation->spaceCharges;

                // PROPERTY DISCOUNT
                $this->propertyDiscount += $dailyCalculation->propertyDiscount;
                // todo discount items

                // SELL PRICE
                $this->propertySellPrice += $dailyCalculation->spaceSellPrice   ;

                // PROPERTY TAX
                $this->propertyTax += $dailyCalculation->propertyTax;

                foreach($dailyCalculation->propertyTaxItems as $i => $dailyTaxItem) {
                    $flag = false;
                    foreach($this->propertyTaxItems as $j => $propertyTaxItem) {
                        if($propertyTaxItem->type === $dailyTaxItem->type) {
                            $flag = true;
                            $this->propertyTaxItems[$j]->amount += $dailyTaxItem->amount;
                        }
                    }

                    if(!$flag) {
                        $this->propertyTaxItems->add(new TaxItem([
                            'type' => $dailyTaxItem->type,
                            'amount' => $dailyTaxItem->amount,
                        ]));
                    }
                }

                // COMMISSION
                $this->otaCommission += $dailyCalculation->otaCommission;
                $this->otaCommissionPercentage = $dailyCalculation->otaCommissionPercentage;
                $this->otaCommissionTax += $dailyCalculation->otaCommissionTax;
                $this->finalOtaCommission += $dailyCalculation->finalOtaCommission;
                foreach($dailyCalculation->otaCommissionTaxItems as $i => $dailyTaxItem) {
                    $flag = false;
                    foreach($this->otaCommissionTaxItems as $j => $otaCommissionTaxItem) {
                        if($otaCommissionTaxItem->type === $dailyTaxItem->type) {
                            $flag = true;
                            $this->otaCommissionTaxItems[$j]->amount += $dailyTaxItem->amount;
                        }
                    }
                    if(!$flag) {
                        $this->otaCommissionTaxItems->add($dailyTaxItem);
                    }
                }

                // AFFILIATE COMMISSION
                if($dailyCalculation->affiliateCommission) {
                    if(!$this->affiliateCommission) {
                        $this->affiliateCommission = new AffiliateCommission;
                    }

                    $this->affiliateCommission->addFromAffiliateCommission($dailyCalculation->affiliateCommission);
                }

                // PROPERTY GROSS CHARGES
                $this->propertyGrossCharges += $dailyCalculation->spaceGrossCharges;
            }
        }

        $this->chargesAfterAllDiscounts = round($this->propertySellPrice - $this->otaDiscount, self::DEFAULT_PRECISION);

        // tds and tcs and commission
        $this->tds = (float) bcdiv(bcmul($this->propertySellPrice, $this->tdsPercentage), 100, self::DEFAULT_PRECISION);
        $this->tcs = (float) bcdiv(bcmul($this->propertySellPrice, $this->tcsPercentage), 100, self::DEFAULT_PRECISION);
        $this->otaToPayPropertyAmount = round($this->propertyGrossCharges - $this->finalOtaCommission - $this->tds - $this->tcs);

        $this->taxAndCharges = round($this->propertyTax + $this->finalOtaServiceCharges, self::DEFAULT_PRECISION);

        $this->guestPayableAmount = round($this->propertyGrossCharges - $this->otaDiscount + $this->finalOtaServiceCharges, self::GUEST_AMOUNT_PRECISION);
        $this->calculateGuestAmounts();

        return $this;
    }

    /**
     * @param int $perc
     * @return $this
     */
    public function calculateOtaServiceCharges(int $perc): static
    {
        $this->otaServiceChargePercentage = $perc;
        $this->otaServiceCharges = (float) bcdiv(bcmul($this->propertySellPrice, $perc), 100, self::DEFAULT_PRECISION);
        $this->otaServiceChargeTax = 0;
        $this->otaServiceChargeTaxItems = new ArrayCollection;


        $tax = (float) bcdiv(bcmul($this->otaServiceCharges, 9), 100, self::DEFAULT_PRECISION);

        $this->otaServiceChargeTax += $tax;
        $this->otaServiceChargeTaxItems->add(new TaxItem([
            'type' => TaxItem::TYPE_CGST,
            'amount' => $tax,
            'percentage' => 9
        ]));

        $this->otaServiceChargeTax += $tax;
        $this->otaServiceChargeTaxItems->add(new TaxItem([
            'type' => TaxItem::TYPE_SGST,
            'amount' => $tax,
            'percentage' => 9
        ]));

        $this->finalOtaServiceCharges = round($this->otaServiceCharges + $this->otaServiceChargeTax, self::DEFAULT_PRECISION);

        $this->guestPayableAmount = round($this->propertyGrossCharges - $this->otaDiscount + $this->finalOtaServiceCharges, self::GUEST_AMOUNT_PRECISION);

        $this->taxAndCharges = round($this->propertyTax + $this->finalOtaServiceCharges, self::DEFAULT_PRECISION);

        $this->calculateGuestAmounts();

        return $this;
    }

    protected function calculateGuestAmounts()
    {
        if(!$this->paymentMode) abort(500, 'Payment mode not set');

        // PAY NOW
        if($this->paymentMode === self::PAYMENT_MODE_PAY_NOW) {
            $this->guestPayNowAmount = $this->guestPayableAmount;
            $this->guestPayLaterAmount = 0;
        }

        // PAY PARTIAL
        elseif($this->paymentMode === self::PAYMENT_MODE_PAY_PARTIAL) {
            if(!$this->partialPayment) abort(500, 'partial payment configuration not defined');

            if($this->partialPayment->valueType == PartialPayment::VALUE_TYPE_PERC) {
                if($this->partialPayment->value > 99) {
                    abort(500, 'Invalid partial payment percentage value');
                }
                // todo
                $this->guestPayNowAmount = (float) bcdiv(bcmul($this->guestPayableAmount, $this->partialPayment->value), 100, self::GUEST_AMOUNT_PRECISION);
                $this->guestPayLaterAmount = round($this->guestPayableAmount - $this->guestPayNowAmount, self::GUEST_AMOUNT_PRECISION);
            } elseif($this->partialPayment->valueType == PartialPayment::VALUE_TYPE_FLAT) {
                if($this->partialPayment->value >= $this->guestPayableAmount) {
                    abort(500, 'partial payment value is more than guest total payable amount');
                }
                $this->guestPayNowAmount = $this->partialPayment->value;
                $this->guestPayLaterAmount = round($this->guestPayableAmount - $this->guestPayNowAmount, self::GUEST_AMOUNT_PRECISION);
            } else {
                abort(500, 'unknown partial payment value type');
            }
        }

        // PAY LATER
        elseif($this->paymentMode === self::PAYMENT_MODE_PAY_AT_PROPERTY) {
            $this->guestPayNowAmount = $this->guestPayableAmount;
            $this->guestPayLaterAmount = 0;
        }

        else {
            abort(500, 'unknown payment type ' . $this->paymentMode);
        }
    }


    public function setOtaDiscount(float|int $discount, OtaDiscountItem $discountItem = null)
    {
        if($discountItem) {
            $this->otaDiscountItems->add($discountItem);
        }
        $this->otaDiscount = round($this->otaDiscount + $discount, self::DEFAULT_PRECISION);
        $this->calculate();
    }

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->bookingSpaces = new ArrayCollection;
        $this->propertyDiscountItems = new ArrayCollection;
        $this->propertyTaxItems = new ArrayCollection;
        $this->otaCommissionTaxItems = new ArrayCollection;
        $this->otaDiscountItems = new ArrayCollection;
        $this->otaServiceChargeTaxItems = new ArrayCollection;

        parent::__construct($attributes);
    }

    public function hasCouponOfID(string|ObjectId $id): bool
    {
        $id = $id instanceof ObjectId ?  $id : new ObjectId($id);
        return collect($this->otaDiscountItems)->firstWhere('couponID', $id) !== null;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
