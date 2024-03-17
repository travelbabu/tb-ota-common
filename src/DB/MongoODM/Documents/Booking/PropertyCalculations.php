<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyCalculations extends EmbeddedDocument
{
    /**
     * @var ArrayCollection<PropertySpaceCalculation>
     * @ODM\EmbedMany  (targetDocument=PropertySpaceCalculation::class)
     */
    public $spaceWiseBreakup;

    /**
     * @var ?PropertySpaceCharges
     * @ODM\EmbedOne (targetDocument=PropertySpaceCharges::class)
     */
    public $spaceCharges;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $tds = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $tcs = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaToPayPropertyAmount = 0;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->spaceWiseBreakup = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @param PropertySpaceCalculation $calculation
     * @return $this
     */
    public function addSpaceCalculations(PropertySpaceCalculation $calculation): static
    {
        $this->spaceWiseBreakup->add($calculation);

        return $this->calculate();
    }

    /**
     * @return $this
     */
    public function calculateSpaceChargesFromBreakup(): static
    {
        $this->spaceCharges = new PropertySpaceCharges;
        foreach($this->spaceWiseBreakup as $spaceWiseBreakupItem) {
            foreach ($spaceWiseBreakupItem->timelyBreakup as $timelyBreakupItem) {
                $this->spaceCharges->addSpaceCharges($timelyBreakupItem);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function calculate(): static
    {
        $baseAmount = 0;
        $extraGuestAmount = 0;
        $amount = 0;
        foreach($this->spaceWiseBreakup as $spaceWiseBreakup) {
            foreach ($spaceWiseBreakup->timelyBreakup as $timelyBreakupItem) {
                $baseAmount += $timelyBreakupItem->spaceCharges->baseAmount;
                $extraGuestAmount += $timelyBreakupItem->spaceCharges->extraGuestAmount;
                $amount += $timelyBreakupItem->spaceCharges->total;
            }
        }


        // basic values
        $this->spaceCharges = new PropertySpaceCharges([
            'baseAmount' => $baseAmount,
            'extraGuestAmount' => $extraGuestAmount,
            'total' => $amount,
        ]);

        // discount
        $bookingDiscount = new SpaceDiscount;

        foreach($this->spaceWiseBreakup as $spaceWiseBreakup) {
            foreach ($spaceWiseBreakup->timelyBreakup as $timelyBreakupItem) {
                foreach (($timelyBreakupItem->spaceCharges->spaceDiscount->breakup ?? []) as $breakupItem) {
                    $bookingDiscount->mergeBreakupItem($breakupItem);
                }
            }
        }
        $this->spaceCharges->spaceDiscount = $bookingDiscount;
        $this->spaceCharges->calculateAmountAfterDiscount();

        // tax
        $propertyTax = new Tax;
        foreach($this->spaceWiseBreakup as $spaceWiseBreakup) {
            foreach ($spaceWiseBreakup->timelyBreakup as $timelyBreakupItem) {
                foreach (($timelyBreakupItem->spaceCharges->tax->breakup ?? []) as $breakupItem) {
                    $propertyTax->mergeBreakupItem($breakupItem);
                }
            }
        }
        $this->spaceCharges->tax = $propertyTax;
        $this->spaceCharges->calculateAmountAfterTax();


        $otaCommission = new OtaCommission;
        foreach($this->spaceWiseBreakup as $spaceWiseBreakup) {
            foreach ($spaceWiseBreakup->timelyBreakup as $timelyBreakupItem) {
                if (!$timelyBreakupItem->spaceCharges->otaCommission) {
                    continue;
                }
                $otaCommission->add($timelyBreakupItem->spaceCharges->otaCommission);
                $otaCommission->calculateAmountAfterTax();
            }
        }
        $this->spaceCharges->otaCommission = $otaCommission;
        $this->spaceCharges->calculateAmountAfterOtaCommission();

        $this->tds = (float) bcdiv(bcmul($this->spaceCharges->amountAfterDiscount, 1), 100, 2);
        $this->tcs = (float) bcdiv(bcmul($this->spaceCharges->amountAfterDiscount, 1), 100, 2);
        $this->otaToPayPropertyAmount = round($this->spaceCharges->amountAfterDiscount - $this->spaceCharges->otaCommission->amount - $this->tds - $this->tcs);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
