<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\OtaBankAccount\embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\OtaBankAccount\OtaBankAccount;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class OtaBankAccountReference extends EmbeddedDocument
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
     * @param OtaBankAccount $bankAccount
     * @return OtaBankAccountReference
     */
    public static function createFromOtaBankAccount(OtaBankAccount $bankAccount): OtaBankAccountReference
    {
        $ref = new OtaBankAccountReference;
        $ref->accountHolder = $bankAccount->accountHolder;
        $ref->accountNumber = $bankAccount->accountNumber;
        $ref->ifsc = $bankAccount->ifsc;
        $ref->bankName = $bankAccount->bankName;
        $ref->branchName = $bankAccount->branchName;
        $ref->branchCode = $bankAccount->branchCode;

        return $ref;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
