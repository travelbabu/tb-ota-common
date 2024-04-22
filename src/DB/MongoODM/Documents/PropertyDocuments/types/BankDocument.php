<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\types;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\BankDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyDocument;
use SYSOTEL\OTA\Common\Enums\PropertyDocumentType;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document
 */
class BankDocument extends PropertyDocument
{
    /**
     * @var ?BankDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\BankDetails::class)
     */
    public $details;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge([
            'details' => toArrayOrNull($this->details),
        ]);
    }

    /**
     * @return PropertyDocumentType
     */
    public function getType(): PropertyDocumentType
    {
        return PropertyDocumentType::BANK_DETAILS;
    }
}
