<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class GuestSpaceCalculation extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $spaceNo;

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
     * @var ArrayCollection<GuestTimelyCalculation>
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
        $this->calculateSpaceChargesFromBreakup();

        $this->chargesAfterAllDiscounts = round($this->spaceCharges->amountAfterDiscount - $this->spaceCharges->otaDiscount->amount, 2);
        $this->taxAndCharges = round($this->spaceCharges->tax->amount + $this->spaceCharges->serviceCharges->amountAfterTax, 2);

        return $this;
    }
    
    /**
     * Document should have rates, discount, tax, commission
     */
    public function calculateSpaceChargesFromBreakup(): static
    {
        $this->spaceCharges = new GuestSpaceCharges;
        foreach($this->timelyBreakup as $timelyBreakupItem) {
            $this->spaceCharges->addSpaceCharges($timelyBreakupItem);
        }

        return $this;
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
