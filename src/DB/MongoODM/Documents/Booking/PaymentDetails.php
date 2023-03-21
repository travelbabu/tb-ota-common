<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class PaymentDetails extends EmbeddedDocument
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $paymentType;
//    public const PAYMENT_TYPE_CASH = 'CASH';

    /**
     * @var ArrayCollection & PropertyDiscountItem[]
     * @ODM\EmbedMany(targetDocument=BookingDiscountItem::class)
     */
    public $details;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'items' => collect($this->items)->toArray(),
        ];
    }
}
