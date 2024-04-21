<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\Helpers\Enums;

/**
 * @ODM\EmbeddedDocument
 */
class BookingCustomPayment extends BookingPayment
{

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }

    public function getType(): string
    {
        return Enums::PAYMENT_SERVICE_CUSTOM;
    }
}
