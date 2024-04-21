<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

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
}
