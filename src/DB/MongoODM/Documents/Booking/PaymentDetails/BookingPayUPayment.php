<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Payments\PayUPaymentDetails;
use SYSOTEL\OTA\Common\Helpers\Enums;

/**
 * @ODM\EmbeddedDocument
 */
class BookingPayUPayment extends BookingPayment
{
    /**
     * @var PayUPaymentDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Payments\PayUPaymentDetails::class)
     */
    public $details;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return Enums::PAYMENT_SERVICE_PAYU_PG;
    }
}
