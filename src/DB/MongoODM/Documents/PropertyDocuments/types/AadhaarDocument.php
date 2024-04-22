<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\types;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\AadhaarDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyDocument;
use SYSOTEL\OTA\Common\Enums\PropertyDocumentType;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document
 */
class AadhaarDocument extends PropertyDocument
{
    /**
     * @var ?AadhaarDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\AadhaarDetails::class)
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
        return PropertyDocumentType::AADHAAR;
    }
}
