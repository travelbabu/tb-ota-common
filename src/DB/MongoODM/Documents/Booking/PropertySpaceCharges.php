<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\isSignedNumber;
use function SYSOTEL\OTA\Common\Helpers\isValidPercentage;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class PropertySpaceCharges extends EmbeddedDocument
{
    /**
     * @var ArrayCollection & SpaceRateItem[]
     * @ODM\EmbedMany (targetDocument=BookingRateItem::class)
     */
    public $appliedRates;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $baseAmount = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $extraGuestAmount = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $total = 0;

    /**
     * @var ?SpaceDiscount
     * @ODM\EmbedOne (targetDocument=SpaceDiscount::class)
     */
    public $spaceDiscount;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amountAfterDiscount = 0;

    /**
     * @var ?Tax
     * @ODM\EmbedOne (targetDocument=Tax::class)
     */
    public $tax;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amountAfterTax = 0;

    /**
     * @var ?OtaCommission
     * @ODM\EmbedOne (targetDocument=OtaCommission::class)
     */
    public $otaCommission;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amountAfterOtaCommission = 0;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->appliedRates = new ArrayCollection;
        $this->spaceDiscount = new SpaceDiscount;
        $this->tax = new Tax;
        $this->otaCommission = new OtaCommission;

        parent::__construct($attributes);
    }

    public function addRateItem(SpaceRateItem $item): static
    {
        $this->appliedRates->add($item);
        return $this;
    }

    /**
     * Document should have rates, discount, tax, commission
     */
    public function calculate(): static
    {
        $this->calculateChargesFromRateBreakup();
        $this->calculateAmountAfterDiscount();
        $this->calculateAmountAfterTax();
        $this->calculateAmountAfterOtaCommission();

        return $this;
    }

    /**
     * @return $this
     */
    public function calculateChargesFromRateBreakup(): static
    {
        $this->baseAmount = 0;
        $this->extraGuestAmount = 0;
        $baseRates = collect($this->appliedRates)->where('type', SpaceRateItem::TYPE_BASE_CHARGES);
        foreach ($baseRates as $appliedRate) {
            if ($appliedRate->type = SpaceRateItem::TYPE_BASE_CHARGES) {
                $this->baseAmount = round($this->baseAmount + $appliedRate->charges, 2);
            }

            if (in_array($appliedRate->type, [SpaceRateItem::TYPE_EXTRA_ADULT_CHARGES, SpaceRateItem::TYPE_EXTRA_CHILD_CHARGES])) {
                $this->extraGuestAmount += $appliedRate->charges;
            }
        }

        $this->amountBeforeMarkup = round($this->baseAmount + $this->extraGuestAmount, 2);
        $this->total = round($this->baseAmount + $this->extraGuestAmount, 2);

        return $this;
    }

    /**
     * @return $this
     */
    public function calculateAmountAfterDiscount(): static
    {
        if (!$this->spaceDiscount) {
            $this->spaceDiscount = new SpaceDiscount;
        }

        $amountAfterDiscount = round($this->total - $this->spaceDiscount->amount, 2);
        if (isSignedNumber($amountAfterDiscount)) {
            $this->amountAfterDiscount = $amountAfterDiscount;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function calculateAmountAfterTax(): static
    {
        if (!$this->tax) {
            $this->tax = new Tax;
        }

        $this->amountAfterTax = round($this->amountAfterDiscount + $this->tax->amount, 2);

        return $this;
    }

    /**
     * @return $this
     */
    public function calculateAmountAfterOtaCommission(): static
    {
        $this->amountAfterOtaCommission = round($this->amountAfterTax + $this->otaCommission->amountAfterTax, 2);

        return $this;
    }

    /**
     * @return PropertySpaceCharges
     */
    public function applyGst(): static
    {
        $totalAmount = $this->amountAfterDiscount;

        if ($totalAmount <= 7999) $percentage = 12;
        else $percentage = 18;

        $taxAmount = (float)bcdiv(bcmul($totalAmount, $percentage), 100, 2);

        $tax = new Tax;
        $tax->breakup = new ArrayCollection;
        $tax->breakup->add(new TaxItem([
            'type' => TaxItem::TYPE_GST,
            'amount' => $taxAmount,
            'percentage' => $percentage
        ]));
        $tax->calculateFromBreakup();
        $this->tax = $tax;

        return $this;
    }

    /**
     * @param float $percentage
     * @return $this
     */
    public function applyOtaCommission(float $percentage): static
    {
        if (!isValidPercentage($percentage)) {
            return $this;
        }

        $amountAfterDiscount = $this->amountAfterDiscount;
        if (!isSignedNumber($amountAfterDiscount, false)) {
            return $this;
        }

        $otaCommission = new OtaCommission;
        $otaCommission->amount = (float)bcdiv(bcmul($amountAfterDiscount, $percentage), 100, 2);

        $taxAmount = (float)bcdiv(bcmul($otaCommission->amount, 18), 100, 2);

        $tax = new Tax;
        $tax->breakup = new ArrayCollection;
        $tax->breakup->add(new TaxItem([
            'type' => TaxItem::TYPE_GST,
            'amount' => $taxAmount,
            'percentage' => 18
        ]));
        $tax->calculateFromBreakup();

        $otaCommission->tax = $tax;
        $otaCommission->calculateAmountAfterTax();

        $this->otaCommission = $otaCommission;

        $this->calculateAmountAfterOtaCommission();

        return $this;
    }

    /**
     * @param PropertySpaceCharges $spaceCharges
     * @return $this
     */
    public function addSpaceCharges(PropertySpaceCharges $spaceCharges): static
    {
        $this->baseAmount = round($this->baseAmount + $spaceCharges->baseAmount, 2);
        $this->extraGuestAmount = round($this->extraGuestAmount + $spaceCharges->extraGuestAmount, 2);
        $this->total = round($this->total + $spaceCharges->total, 2);
        $this->spaceDiscount->add($spaceCharges->spaceDiscount);
        $this->tax->add($spaceCharges->tax);
        $this->otaCommission->add($spaceCharges->otaCommission);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'serviceCharges' => toArrayOrNull($this->otaCommission),
        ];
    }
}
