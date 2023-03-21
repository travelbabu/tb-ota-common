<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use phpDocumentor\Reflection\Types\Self_;

/**
 * @ODM\EmbeddedDocument
 */
class GuestPayment extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_PG_CASHFREE = 'PG_CASHFREE';
    public const TYPE_INTERNAL_WALLET = 'INTERNAL_WALLET';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentMethod;
    public const PAYMENT_METHOD_INTERNAL_WALLET = 'INTERNAL_WALLET';
    public const PAYMENT_METHOD_UPI = 'UPI';
    public const PAYMENT_METHOD_CARD = 'CARD';
    public const PAYMENT_METHOD_DEBIT_CARD = 'DEBIT_CARD';
    public const PAYMENT_METHOD_CREDIT_CARD = 'CREDIT_CARD';
    public const PAYMENT_METHOD_NET_BANKING = 'NET_BANKING';
    public const PAYMENT_METHOD_UNKNOWN = 'UNKNOWN';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $globalID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $vendorReferenceID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $vendorOrderID;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amountToBePaid;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amountPaid;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_FAILURE = 'FAILURE';

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $acknowledgeAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $paymentRecievedAt;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $remark;

    public function markAsAcknowledge(string $status = self::STATUS_SUCCESS): static
    {
        $this->acknowledgeAt = now();
        $this->status = $status;
        return $this;
    }

    public function setGlobalID(int $bookingID, int $version): self
    {
        $this->globalID = "bookingPayment_{$bookingID}_{$version}_{$this->id}";
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'amountToBePaid' => $this->amountToBePaid,
            'amountPaid' => $this->amountPaid,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'acknowledgeAt' => $this->acknowledgeAt,
            'vendorReferenceID' => $this->vendorReferenceID,
            'vendorOrderID' => $this->vendorOrderID,
            'remark' => $this->remark,
        ];
    }
}
