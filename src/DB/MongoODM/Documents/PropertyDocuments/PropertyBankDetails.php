<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments;

use Delta4op\MongoODM\Facades\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Contracts\PropertyDocumentContract;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyBankDetailsRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="propertyBankDetails",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyBankDetailsRepository::class
 * )
 */
class PropertyBankDetails extends PropertyDocumentDetails
{

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyBankDetails';

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
        return array_merge(parent::toArray(), arrayFilter([
            'accountHolder'     => $this->accountHolder,
            'accountNumber'     => $this->accountNumber,
            'ifsc'              => $this->ifsc,
            'bankName'          => $this->bankName,
            'branchName'        => $this->branchName,
            'branchCode'        => $this->branchCode,
        ]));
    }

    /**
     * User Repository
     *
     * @return PropertyBankDetailsRepository
     */
    public static function repository(): PropertyBankDetailsRepository
    {
        return DocumentManager::getRepository(self::class);
    }

    public function docTypeLabel(): string
    {
        return 'Bank Details';
    }

    public function docType(): string
    {
        return 'BANK';
    }
}
