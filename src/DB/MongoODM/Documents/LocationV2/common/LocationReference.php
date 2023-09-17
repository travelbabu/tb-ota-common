<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\Location;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class LocationReference extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="object_id")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @param Location $location
     * @return LocationReference
     */
    public static function createFromLocation(Location $location): LocationReference
    {
        return new self([
            'id' => $location->id,
            'name' => $location->name,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'name' => $this->name,
        ]);
    }
}
