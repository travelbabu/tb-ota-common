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
                $baseAmount += $timelyBreakupItem->getSpaceCharges()->getBaseAmount();
                $extraGuestAmount += $timelyBreakupItem->getSpaceCharges()->getExtraGuestAmount();
                $amount += $timelyBreakupItem->getSpaceCharges()->getAmount();
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

        $this->spaceCharges->calculateAmountAfterOtaCommission();

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
