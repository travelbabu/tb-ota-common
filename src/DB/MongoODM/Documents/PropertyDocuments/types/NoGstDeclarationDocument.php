<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\types;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyDocument;
use SYSOTEL\OTA\Common\Enums\PropertyDocumentType;

/**
 * @ODM\EmbeddedDocument
 */
class NoGstDeclarationDocument extends PropertyDocument
{
    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge([

        ]);
    }

    /**
     * @return PropertyDocumentType
     */
    public function getType(): PropertyDocumentType
    {
        return PropertyDocumentType::NO_GST_DECLARATION;
    }
}
