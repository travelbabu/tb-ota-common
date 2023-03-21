<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyOtaContract;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyBankDetails;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ContractPropertyBankDetails extends EmbeddedDocument
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

    public static function createFromBankDetails(PropertyBankDetails $bankDetails): ContractPropertyBankDetails
    {
        return new self([
            'accountHolder' => $bankDetails->accountHolder,
            'accountNumber' => $bankDetails->accountNumber,
            'ifsc' => $bankDetails->ifsc,
        ]);
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'accountHolder' => $this->accountHolder,
            'accountNumber' => $this->accountNumber,
            'ifsc' => $this->ifsc,
        ]);
    }
}
