<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Payments\CashfreePaymentDetails;
use SYSOTEL\OTA\Common\Helpers\Enums;

/**
 * @ODM\EmbeddedDocument
 */
class BookingCashfreePayment extends BookingPayment
{
    /**
     * @var CashfreePaymentDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Payments\CashfreePaymentDetails::class)
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

    public function getType(): string
    {
        return Enums::PAYMENT_SERVICE_PROVIDER;
    }
}
