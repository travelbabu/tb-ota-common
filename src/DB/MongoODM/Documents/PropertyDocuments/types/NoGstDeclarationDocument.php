<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\types;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\PanDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyDocument;
use SYSOTEL\OTA\Common\Helpers\Enums;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

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
     * @return string
     */
    public function getType(): string
    {
        return Enums::PROPERTY_DOCUMENT_NO_GST_DECLARATION;
    }
}
