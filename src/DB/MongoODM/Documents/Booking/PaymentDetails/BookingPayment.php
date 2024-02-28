<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;


/**
 * @ODM\MappedSuperclass
 */
abstract class BookingPayment extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $_id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $no;

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
    public $paymentGroup;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentMethod;
    // todo paymentGroupDetails

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
    public $paymentReceivedAt;

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

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->_id,
            'no' => $this->no,
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
