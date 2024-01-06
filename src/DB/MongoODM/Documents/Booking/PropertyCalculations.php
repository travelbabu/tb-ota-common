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
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
