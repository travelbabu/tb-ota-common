<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class OtaCommission extends EmbeddedDocument
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amount = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $percentage = 0;

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
     * @return OtaCommission
     */
    public function applyGst(): static
    {
        $taxAmount = (float)bcdiv(bcmul($this->amount, 18), 100, 2);

        $tax = new Tax;
        $tax->breakup = new ArrayCollection;
        $tax->breakup->add(new TaxItem([
            'type' => TaxItem::TYPE_GST,
            'amount' => $taxAmount,
            'percentage' => 18
        ]));
        $tax->calculateFromBreakup();
        $this->tax = $tax;

        return $this;
    }

    /**
     * @param OtaCommission $charges
     * @return $this
     */
    public function add(OtaCommission $charges): static
    {
        if(!$this->tax) {
            $this->tax = new Tax;
        }

        $this->amount = round($this->amount + $charges->amount, 2);
        $this->amountAfterTax = round($this->amountAfterTax + $charges->amountAfterTax, 2);

        if ($this->percentage !== $charges->percentage) {
            $this->percentage = null;
        }

        $this->tax->add($charges->tax);

        return $this;
    }

    /**
     * @return static
     */
    public function calculateAmountAfterTax(): static
    {
        $this->amountAfterTax = $this->amount = $this->tax->amount;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'percentage' => $this->percentage,
            'tax' => toArrayOrNull($this->tax),
            'amountAfterTax' => $this->amountAfterTax,
        ];
    }
}
