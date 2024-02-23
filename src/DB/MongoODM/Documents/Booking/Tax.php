<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class Tax extends EmbeddedDocument
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amount = 0;

    /**
     * @var ArrayCollection & TaxItem[]
     * @ODM\EmbedMany (targetDocument=TaxItem::class)
     */
    public $breakup;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->breakup = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @param Tax $tax
     * @return $this
     */
    public function add(Tax $tax): static
    {
        $this->amount = round($this->amount + $tax->amount, 2);

        foreach($tax->breakup as $breakupItem) {
            $this->mergeBreakupItem($breakupItem);
        }

        return $this;
    }

    /**
     * @param TaxItem $taxItem
     * @return $this
     */
    public function mergeBreakupItem(TaxItem $taxItem): static
    {
        $matchFound = false;

        $itemCopy = new TaxItem;
        $itemCopy->type = $taxItem->type;
        $itemCopy->percentage = $taxItem->percentage;
        $itemCopy->amount = $taxItem->amount;

        foreach ($this->breakup as $breakupItem) {
            if ($itemCopy->type === $breakupItem->type) {

                $breakupItem->addAmount($itemCopy->amount);

                if ($breakupItem->percentage !== $itemCopy->percentage) {
                    $breakupItem->percentage = null;
                }

                $matchFound = true;
                break;
            }
        }

        if (!$matchFound) {
            $this->breakup->add($itemCopy);
        }

        return $this->calculateFromBreakup();
    }

    /**
     * @return $this
     */
    public function calculateFromBreakup(): static
    {
        $this->amount = 0;

        foreach ($this->breakup as $taxItem) {
            $this->amount = round($this->amount + $taxItem->amount, 2);
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
