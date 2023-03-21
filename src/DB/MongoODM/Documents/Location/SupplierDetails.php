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
class SupplierDetails extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var PropertyCount
     * @ODM\EmbedOne(targetDocument=PropertyCount::class)
     */
    public $propertyCount;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'             => $this->id,
            'name'           => $this->name,
            'propertyCount'  => toArrayOrNull($this->propertyCount),
        ]);
    }
}
