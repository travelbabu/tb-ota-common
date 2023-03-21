<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\Area;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\City;
use function SYSOTEL\OTA\Common\Helpers\googleMapURL;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class AreaReference extends EmbeddedDocument
{
    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $slug;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @param Area $area
     * @return AreaReference
     */
    public static function createFromArea(Area $area): AreaReference
    {
        return new self([
            'id' => new ObjectId($area->id),
            'slug' => $area->slug,
            'name' => $area->name,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
        ]);
    }
}
