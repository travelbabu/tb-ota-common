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
    private $merchantID;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $orderID;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $payUKey;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $mihpayID;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $payuSalt;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $mode;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $bankcode;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $status;


    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $unmappedStatus;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $error;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $errorMessage;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $bankRefNum;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $txnid;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $transactionID;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $payUTransactionID;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $amount;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $netAmountDebit;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $addedOn;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $productInfo;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $firstName;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $email;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $phone;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $pgType;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $merchantUtr;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $meCode;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $appName;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $cardNo;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $cardType;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $disc;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $hash;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $sUrl;


    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    private $fUrl;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
