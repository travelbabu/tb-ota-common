<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\types;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyDocument;
use SYSOTEL\OTA\Common\Enums\PropertyDocumentType;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class TradeLicence extends PropertyDocument
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
        return PropertyDocumentType::TRADE_LICENCE;
    }
}
