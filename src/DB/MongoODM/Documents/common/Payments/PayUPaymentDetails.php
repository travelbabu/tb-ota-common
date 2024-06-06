<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Payments;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class PayUPaymentDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $merchantID;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $orderID;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $payUKey;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $mihpayID;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $payuSalt;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $mode;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $bankcode;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $status;


    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $unmappedStatus;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $error;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $errorMessage;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $bankRefNum;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $txnid;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $transactionID;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $payUTransactionID;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $amount;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $netAmountDebit;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $addedOn;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $productInfo;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $firstName;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $email;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $phone;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $pgType;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $merchantUtr;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $meCode;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $appName;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $cardNo;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $cardType;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $disc;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $hash;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $sUrl;


    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $fUrl;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
