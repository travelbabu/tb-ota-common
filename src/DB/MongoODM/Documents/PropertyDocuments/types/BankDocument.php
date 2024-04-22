<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\types;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\BankDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\PanDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyDocument;
use SYSOTEL\OTA\Common\Helpers\Enums;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
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
     * @return string
     */
    public function getType(): string
    {
        return Enums::PROPERTY_DOCUMENT_BANK_DETAILS;
    }
}
