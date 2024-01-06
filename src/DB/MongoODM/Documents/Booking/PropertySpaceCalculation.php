<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

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
        $this->calculateSpaceChargesFromBreakup();

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
