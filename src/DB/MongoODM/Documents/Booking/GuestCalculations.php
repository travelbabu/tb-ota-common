<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;

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
    public $guestPayableAmount = 0;

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
                $amount += $timelyBreakupItem->spaceCharges->total;
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

        $this->spaceCharges->calculateAmountAfterOtaDiscount();

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
        $this->spaceCharges->serviceCharges = $serviceCharges;
        $this->spaceCharges->calculateAmountAfterServiceCharges();

        $this->guestPayableAmount = $this->spaceCharges->amountAfterServiceCharges;

        return $this;
    }

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
