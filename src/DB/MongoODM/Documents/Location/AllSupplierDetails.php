<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\googleMapURL;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class AllSupplierDetails extends EmbeddedDocument
{
    /**
     * @var SupplierDetails
     * @ODM\EmbedOne(targetDocument=SupplierDetails::class)
     */
    public $self;

    /**
     * @var SupplierDetails
     * @ODM\EmbedOne(targetDocument=SupplierDetails::class)
     */
    public $tgr;


    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'self' => toArrayOrNull($this->self),
            'tgr'  => toArrayOrNull($this->tgr),
        ]);
    }
}
