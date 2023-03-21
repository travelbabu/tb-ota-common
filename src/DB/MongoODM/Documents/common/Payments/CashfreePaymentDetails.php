<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Payments;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
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
    public $paymentSessionId;

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
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
