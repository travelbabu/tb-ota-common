<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class BookingPaymentDetails extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentMode;
    public const PAYMENT_MODE_PAY_NOW = 'PAY_NOW';
    public const PAYMENT_MODE_PAY_AT_PROPERTY = 'PAY_AT_PROPERTY';
    public const PAYMENT_MODE_PAY_PARTIAL = 'PAY_PARTIAL';

    /**
     * @var PartialPayment
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment::class)
     */
    public $partialPayment;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var ArrayCollection & array{BookingCashfreePayment|BookingPayUPayment|BookingCustomPayment}
     *
     * @ODM\EmbedMany(
     *   discriminatorMap={
     *     "PG_CASHFREE"=BookingCashfreePayment::class,
     *     "PG_PAYU"=BookingPayUPayment::class,
     *     "CUSTOM"=BookingCustomPayment::class
     *   }
     * )
     */
    public $payments;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amountToBePaid;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amountPaid = 0;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->payments = new ArrayCollection;

        parent::__construct($attributes);
    }

    public function getPaymentById(string|int $id): BookingPayment|null
    {
        foreach ($this->payments as $payment) {
            if ($payment->_id == $id) {
                return $payment;
            }
        }
        return null;
    }

    public function getNewGuestPaymentID(): int
    {
        $id = 1;
        foreach ($this->payments as $payment) {
            if ($payment->id > $id) {
                $id = $payment->id;
            }
        }

        return $id + 1;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'paymentMode' => $this->paymentMode,
            'partialPayment' => toArrayOrNull($this->partialPayment),
            'amountToBePaid' => $this->amountToBePaid,
            'amountPaid' => $this->amountPaid,
            'status' => $this->status,
            'items' => collect($this->payments)->toArray(),
        ];
    }
}
