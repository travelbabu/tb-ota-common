<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Amenity;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class SupplierDetails extends EmbeddedDocument
{
    /**
     * @var TgrDetails
     * @ODM\EmbedOne(targetDocument=TgrDetails::class)
     */
    public $tgr;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'tgr' => toArrayOrNull($this->tgr),
        ]);
    }
}
