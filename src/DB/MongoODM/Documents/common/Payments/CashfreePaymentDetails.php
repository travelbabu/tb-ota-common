<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Payments;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class CashfreePaymentDetails extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $appID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $secretKey;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentSessionID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $internalOrderID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $cfOrderID;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $orderAmount;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $orderCreatedAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $orderExpiry;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $orderToken;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentLink;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentsUrl;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $orderStatus;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $refundsUrl;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $settlementsUrl;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $customerID;

    /**
     * @var ArrayCollection & CashfreePaymentTransaction[]
     * @ODM\EmbedMany(targetDocument=CashfreePaymentTransaction::class)
     */
    public $transactions;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->transactions = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @param array $data
     * @return CashfreePaymentDetails
     */
    public static function createFromOrderData(array $data): CashfreePaymentDetails
    {
        return (new static)->updateFromOrderData($data);
    }
    /**
     * @param array $data
     * @return static
     */
    public function updateFromOrderData(array $data): static
    {
        $this->paymentSessionID = $data['payment_session_id'] ?? null;
        $this->orderAmount = $data['order_amount'] ?? null;
        $this->cfOrderID = $data['cf_order_id'] ?? null;
        $this->customerID = $data['customer_details']['customer_id'] ?? null;
        $this->internalOrderID = $data['order_id'] ?? null;
        $this->orderExpiry = isset($data['order_expiry_time']) ? Carbon::parse($data['order_expiry_time']) : null;
        $this->paymentsUrl = $data['payments']['url'] ?? null;
        $this->refundsUrl = $data['refunds']['url'] ?? null;
        $this->orderStatus = $data['order_status'] ?? null;
        $this->orderCreatedAt = isset($data['created_at']) ? Carbon::parse($data['created_at']) : null;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'appId' => $this->appID,
            'secretKey' => $this->secretKey,
            'paymentSessionID' => $this->paymentSessionID,
            'internalOrderID' => $this->internalOrderID,
            'cfOrderID' => $this->cfOrderID,
            'orderAmount' => $this->orderAmount,
            'orderCreatedAt' => $this->orderCreatedAt,
            'orderExpiry' => $this->orderExpiry,
            'orderToken' => $this->orderToken,
            'paymentLink' => $this->paymentLink,
            'paymentsUrl' => $this->paymentsUrl,
            'orderStatus' => $this->orderStatus,
            'refundsUrl' => $this->refundsUrl,
            'settlementsUrl' => $this->settlementsUrl,
            'customerID' => $this->customerID,
        ];
    }
}
