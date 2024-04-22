<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\types;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\PanDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyDocument;
use SYSOTEL\OTA\Common\Enums\PropertyDocumentType;
use SYSOTEL\OTA\Common\Helpers\Enums;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class GstDocument extends PropertyDocument
{
    /**
     * @var ?PanDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\PanDetails::class)
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
        return PropertyDocumentType::GST;
    }
}
