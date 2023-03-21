<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class GuestTotalAmount extends EmbeddedDocument
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $totalPayable;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $payNowAmount;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $payLaterAmount;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->value,
            'payNowAmount' => $this->payNowAmount,
            'payLaterAmount' => $this->payLaterAmount,
        ];
    }
}
