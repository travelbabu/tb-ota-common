<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Payments;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class CashfreePaymentTransaction extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field (type="int")
     */
    public $cfPaymentId;

    /**
     * @var ?float
     * @ODM\Field (type="float")
     */
    public $paymentAmount;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $paymentCurrency;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $paymentGroup;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $paymentMessage;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $paymentStatus;

    /**
     * @var ?Carbon
     * @ODM\Field (type="carbon")
     */
    public $paymentCreatedAt;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $entity;

    /**
     * @var ?bool
     * @ODM\Field (type="bool")
     */
    public $isPaymentCaptured;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $paymentErrorDescription;

    /**
     * @var ?float
     * @ODM\Field (type="float")
     */
    public $orderAmount;


    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $paymentBankReference;

    /**
     * @var ?Carbon
     * @ODM\Field (type="carbon")
     */
    public $paymentCompletionTime;

    public static function createFromPayment(array $payment): static
    {
        return new self([
            'cfPaymentId' => $payment['cf_payment_id'] ?? null,
            'paymentAmount' => $payment['payment_amount'] ?? null,
            'paymentCurrency' => $payment['payment_currency'] ?? null,
            'paymentGroup' => $payment['payment_group'] ?? null,
            'paymentMessage' => $payment['payment_message'] ?? null,
            'paymentStatus' => $payment['payment_status'] ?? null,
            'isPaymentCaptured' => $payment['is_captured'] ?? null,
            'paymentErrorDescription' => $payment['error_details'] ?? null,
            'orderAmount' => $payment['order_amount'] ?? null,
            'paymentCreatedAt' => isset($payment['payment_time']) ? Carbon::parse($payment['payment_time']) : null,
            'paymentCompletionTime' => isset($payment['payment_completion_time']) ? Carbon::parse($payment['payment_time']) : null,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'cfPaymentId' => $this->cfPaymentId,
            'paymentAmount' => $this->paymentAmount,
            'paymentCurrency' => $this->paymentCurrency,
            'paymentGroup' => $this->paymentGroup,
            'paymentMessage' => $this->paymentMessage,
            'paymentStatus' => $this->paymentStatus,
            'isPaymentCaptured' => $this->isPaymentCaptured,
            'paymentErrorDescription' => $this->paymentErrorDescription,
            'orderAmount' => $this->orderAmount,
            'paymentCreatedAt' => $this->paymentCreatedAt,
            'paymentCompletionTime' => $this->paymentCompletionTime,
        ];
    }
}
