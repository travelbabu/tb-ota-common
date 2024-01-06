<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyReference extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $displayName;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $starRating;

    /**
     * @var Address
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Address::class)
     */
    public $address;

    /**
     * @param Property $property
     * @return PropertyReference
     */
    public static function createFromProperty(Property $property): PropertyReference
    {
        return new self([
            'id' => $property->id,
            'name' => $property->displayName,
            'starRating' => $property->starRating,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'name' => $this->displayName,
            'starRating' => $this->starRating,
            'address' => toArrayOrNull($this->address),
        ]);
    }
}
