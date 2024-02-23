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
class GuestCalculations extends EmbeddedDocument
{
    public const DEFAULT_PRECISION = 2;
    public const GUEST_AMOUNT_PRECISION = 0;

    /**
     * @var ArrayCollection<GuestSpaceCalculation>
     * @ODM\EmbedMany  (targetDocument=GuestSpaceCalculation::class)
     */
    public $spaceWiseBreakup;

    /**
     * @var ?GuestSpaceCharges
     * @ODM\EmbedOne (targetDocument=GuestSpaceCharges::class)
     */
    public $spaceCharges;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $chargesAfterAllDiscounts = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $taxAndCharges = 0;

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
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->spaceWiseBreakup = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @param GuestSpaceCalculation $calculation
     * @return $this
     */
    public function addSpaceCalculations(GuestSpaceCalculation $calculation): static
    {
        $this->spaceWiseBreakup->add($calculation);

        return $this->calculate();
    }

    /**
     * @return $this
     */
    public function calculate(): static
    {
        $baseAmount = 0;
        $extraGuestAmount = 0;
        $amount = 0;
        foreach($this->spaceWiseBreakup as $spaceWiseBreakupItem) {
            foreach ($spaceWiseBreakupItem->timelyBreakup as $timelyBreakupItem) {
                $baseAmount += $timelyBreakupItem->spaceCharges->baseAmount;
                $extraGuestAmount += $timelyBreakupItem->spaceCharges->extraGuestAmount;
                $amount += $timelyBreakupItem->spaceCharges->amount;
            }
        }


        // basic values
        $this->spaceCharges = new GuestSpaceCharges([
            'baseAmount' => $baseAmount,
            'extraGuestAmount' => $extraGuestAmount,
            'total' => $amount,
        ]);

        // discount
        $bookingDiscount = new SpaceDiscount;
        foreach($this->spaceWiseBreakup as $spaceWiseBreakupItem) {
            foreach ($spaceWiseBreakupItem->timelyBreakup as $timelyBreakupItem) {
                foreach (($timelyBreakupItem->spaceCharges->spaceDiscount->breakup ?? []) as $breakupItem) {
                    $bookingDiscount->mergeBreakupItem($breakupItem);
                }
            }
        }
        $this->spaceCharges->spaceDiscount = $bookingDiscount;
        $this->spaceCharges->calculateAmountAfterDiscount();
        $this->spaceCharges->calculateAmountAfterOtaDiscount();

        // tax
        $propertyTax = new Tax;
        foreach($this->spaceWiseBreakup as $spaceWiseBreakupItem) {
            foreach ($spaceWiseBreakupItem->timelyBreakup as $timelyBreakupItem) {
                foreach (($timelyBreakupItem->spaceCharges->tax->breakup ?? []) as $breakupItem) {
                    $propertyTax->mergeBreakupItem($breakupItem);
                }
            }
        }

        $this->spaceCharges->tax = $propertyTax;
        $this->spaceCharges->calculateAmountAfterTax();


        $serviceCharges = new ServiceCharges;
        foreach($this->spaceWiseBreakup as $spaceWiseBreakupItem) {
            foreach ($spaceWiseBreakupItem->timelyBreakup as $timelyBreakupItem) {

                if (!$timelyBreakupItem->spaceCharges->serviceCharges) {
                    continue;
                }

                $serviceCharges->add($timelyBreakupItem->spaceCharges->serviceCharges);
                $serviceCharges->calculateAmountAfterTax();
            }
        }

        $this->spaceCharges->calculateAmountAfterServiceCharges();

        return $this;
    }

//    /**
//     * @return $this
//     */
//    public function calculateSpaceChargesFromBreakup(): static
//    {
//        $this->spaceCharges = new GuestSpaceCharges;
//
//        foreach($this->spaceWiseBreakup as $spaceWiseBreakupItem) {
//            foreach ($spaceWiseBreakupItem->timelyBreakup as $timelyBreakupItem) {
//                $this->spaceCharges->addSpaceCharges($timelyBreakupItem);
//            }
//        }
//
//        $this->chargesAfterAllDiscounts = round($this->spaceCharges->amountAfterDiscount - $this->spaceCharges->otaDiscount->amount, 2);
//        $this->taxAndCharges = round($this->spaceCharges->tax->amount + $this->spaceCharges->serviceCharges->amountAfterTax, 2);
//
//        $this->guestPayableAmount = $this->spaceCharges->amountAfterServiceCharges;
//        $this->calculateGuestAmounts();
//
//        return $this;
//    }


//    /**
//     * @return void
//     */
//    protected function calculateGuestAmounts(): void
//    {
//        if (!$this->paymentMode) abort(500, 'Payment mode not set');
//
//        // PAY NOW
//        if ($this->paymentMode === self::PAYMENT_MODE_PAY_NOW) {
//            $this->guestPayNowAmount = $this->guestPayableAmount;
//            $this->guestPayLaterAmount = 0;
//        } // PAY PARTIAL
//        elseif ($this->paymentMode === self::PAYMENT_MODE_PAY_PARTIAL) {
//            if (!$this->partialPayment) abort(500, 'partial payment configuration not defined');
//
//            if ($this->partialPayment->valueType == PartialPayment::VALUE_TYPE_PERC) {
//                if ($this->partialPayment->value > 99) {
//                    abort(500, 'Invalid partial payment percentage value');
//                }
//                // todo
//                $this->guestPayNowAmount = (float)bcdiv(bcmul($this->guestPayableAmount, $this->partialPayment->value), 100, 2);
//                $this->guestPayLaterAmount = round($this->guestPayableAmount - $this->guestPayNowAmount, 2);
//            } elseif ($this->partialPayment->valueType == PartialPayment::VALUE_TYPE_FLAT) {
//                if ($this->partialPayment->value >= $this->guestPayableAmount) {
//                    abort(500, 'partial payment value is more than guest total payable amount');
//                }
//                $this->guestPayNowAmount = $this->partialPayment->value;
//                $this->guestPayLaterAmount = round($this->guestPayableAmount - $this->guestPayNowAmount, 2);
//            } else {
//                abort(500, 'unknown partial payment value type');
//            }
//        } // PAY LATER
//        elseif ($this->paymentMode === self::PAYMENT_MODE_PAY_AT_PROPERTY) {
//            $this->guestPayNowAmount = $this->guestPayableAmount;
//            $this->guestPayLaterAmount = 0;
//        } else {
//            abort(500, 'unknown payment type ' . $this->paymentMode);
//        }
//    }

    public function hasCouponOfID(string|ObjectId $id): bool
    {
        $id = $id instanceof ObjectId ? $id : new ObjectId($id);
        return collect($this->spaceCharges->otaDiscount->breakup)->firstWhere('couponID', $id) !== null;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
