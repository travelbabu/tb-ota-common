<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCache;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyAmenityCache extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $amenityID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isFeatured;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $sortOrder;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'amenityID'   => $this->amenityID,
            'name'        => $this->name,
            'isFeatured'  => $this->isFeatured,
            'sortOrder'   => $this->sortOrder,
        ]);
    }
}
