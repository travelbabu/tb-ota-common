<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class SpaceDiscount extends EmbeddedDocument
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amount = 0;

    /**
     * @var ArrayCollection & SpaceDiscountItem[]
     * @ODM\EmbedMany (targetDocument=SpaceDiscountItem::class)
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
     * @param SpaceDiscount $discount
     * @return $this
     */
    public function add(SpaceDiscount $discount): static
    {
        $this->amount = round($this->amount + $discount->amount, 2);

        foreach($discount->breakup as $breakupItem) {
            $this->mergeBreakupItem($breakupItem);
        }

        return $this;
    }

    /**
     * @param SpaceDiscountItem $discountItem
     * @return $this
     */
    public function mergeBreakupItem(SpaceDiscountItem $discountItem): static
    {
        $matchFound = false;

        $itemCopy = new SpaceDiscountItem;
        $itemCopy->appliedOn = $discountItem->appliedOn;
        $itemCopy->promotionDocumentID = $discountItem->promotionDocumentID;
        $itemCopy->promotionID = $discountItem->promotionID;
        $itemCopy->name = $discountItem->name;
        $itemCopy->type = $discountItem->type;
        $itemCopy->code = $discountItem->code;
        $itemCopy->amount = $discountItem->amount;
        $itemCopy->percentage = $discountItem->percentage;
        $itemCopy->description = $discountItem->description;

        foreach ($this->breakup as $breakupItem) {
            if ($itemCopy->promotionDocumentID === $breakupItem->promotionDocumentID) {

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

        foreach ($this->breakup as $discountItem) {
            $this->amount = round($this->amount + $discountItem->amount, 2);
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
