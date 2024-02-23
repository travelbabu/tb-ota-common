<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class PropertySpaceCalculation extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $spaceNo;

    /**
     * @var ?PropertySpaceCharges
     * @ODM\EmbedOne (targetDocument=PropertySpaceCharges::class)
     */
    public $spaceCharges;

    /**
     * @var ArrayCollection<PropertyTimelyCalculation>
     * @ODM\EmbedMany(targetDocument=PropertyTimelyCalculation::class)
     */
    public $timelyBreakup;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->timelyBreakup = new ArrayCollection;

        parent::__construct($attributes);
    }


    /**
     * @return $this
     */
    public function calculate(): static
    {
        $baseAmount = 0;
        $extraGuestAmount = 0;
        $amount = 0;
        foreach ($this->timelyBreakup as $timelyBreakupItem) {
            $baseAmount += $timelyBreakupItem->getSpaceCharges()->getBaseAmount();
            $extraGuestAmount += $timelyBreakupItem->getSpaceCharges()->getExtraGuestAmount();
            $amount += $timelyBreakupItem->getSpaceCharges()->getAmount();
        }

        // basic values
        $this->spaceCharges = new PropertySpaceCharges([
            'baseAmount' => $baseAmount,
            'extraGuestAmount' => $extraGuestAmount,
            'total' => $amount,
        ]);

        // discount
        $bookingDiscount = new SpaceDiscount;
        foreach ($this->timelyBreakup as $timelyBreakupItem) {
            foreach (($timelyBreakupItem->spaceCharges->spaceDiscount->breakup ?? []) as $breakupItem) {
                $bookingDiscount->mergeBreakupItem($breakupItem);
            }
        }
        $this->spaceCharges->spaceDiscount = $bookingDiscount;
        $this->spaceCharges->calculateAmountAfterDiscount();

        // tax
        $propertyTax = new Tax;
        foreach ($this->timelyBreakup as $timelyBreakupItem) {
            foreach (($timelyBreakupItem->spaceCharges->tax->breakup ?? []) as $breakupItem) {
                $propertyTax->mergeBreakupItem($breakupItem);
            }
        }

        $this->spaceCharges->tax = $propertyTax;
        $this->spaceCharges->calculateAmountAfterTax();


        $otaCommission = new OtaCommission;
        foreach ($this->timelyBreakup as $timelyBreakupItem) {
            if(!$timelyBreakupItem->spaceCharges->otaCommission) {
                continue;
            }
            $otaCommission->add($timelyBreakupItem->spaceCharges->otaCommission);
            $otaCommission->calculateAmountAfterTax();
        }

        $this->spaceCharges->calculateAmountAfterOtaCommission();

        return $this;
    }

    public function getTimelyBreakupItemForDate(Carbon $date): bool
    {
        $timelyBreakupItemForDate = null;
        foreach ($this->timelyBreakup as $timelyBreakupItem) {
            $timelyBreakupItemForDate = $timelyBreakupItem->startTime->isSameDay($date);

        }
        return $timelyBreakupItemForDate;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
