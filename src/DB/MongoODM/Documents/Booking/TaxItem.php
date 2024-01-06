<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\isSignedNumber;

/**
 * @ODM\EmbeddedDocument
 */
class TaxItem extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_GST = 'GST';
    public const TYPE_IGST = 'IGST';
    public const TYPE_CGST = 'CGST';
    public const TYPE_SGST = 'SGST';

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
     * @param int|float $newAmount
     * @return static
     */
    public function addAmount(int|float $newAmount): TaxItem
    {
        if (!isSignedNumber($this->amount)) {
            return $this;
        }

        if (!isSignedNumber($newAmount)) {
            return $this;
        }

        $this->amount = round($this->amount + $newAmount, 2);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'percentage' => $this->percentage,
            'type' => $this->type,
            'amount' => $this->amount,
        ];
    }
}
