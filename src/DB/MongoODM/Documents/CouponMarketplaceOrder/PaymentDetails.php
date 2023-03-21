<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CouponMarketplaceOrder;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PaymentDetails extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_PG_CASHFREE = 'PG_CASHFREE';

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
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_FAILURE = 'FAILURE';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentMethod;
    public const PAYMENT_METHOD_UPI = 'UPI';
    public const PAYMENT_METHOD_CARD = 'CARD';
    public const PAYMENT_METHOD_DEBIT_CARD = 'DEBIT_CARD';
    public const PAYMENT_METHOD_CREDIT_CARD = 'CREDIT_CARD';
    public const PAYMENT_METHOD_NET_BANKING = 'NET_BANKING';
    public const PAYMENT_METHOD_UNKNOWN = 'UNKNOWN';

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amountPaid;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $paymentRecievedAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $acknowledgeAt;

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
        return arrayFilter([
            'id' => $this->id,
            'type' => $this->type,
            'vendorReferenceID' => $this->vendorReferenceID,
            'vendorOrderID' => $this->vendorOrderID,
            'amountToBePaid' => $this->amountToBePaid,
            'status' => $this->status,
            'paymentMethod' => $this->paymentMethod,
            'amountPaid' => $this->amountPaid,
            'paymentRecievedAt' => $this->paymentRecievedAt,
            'acknowledgeAt' => $this->acknowledgeAt,
        ]);
    }
}
