<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class BankDetails extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $accountHolder;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $accountNumber;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $ifsc;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $bankName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $branchName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $branchCode;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge([
            'accountHolder' => $this->accountHolder,
            'accountNumber' => $this->accountNumber,
            'ifsc' => $this->ifsc,
            'bankName' => $this->bankName,
            'branchName' => $this->branchName,
            'branchCode' => $this->branchCode,
        ]);
    }
}
