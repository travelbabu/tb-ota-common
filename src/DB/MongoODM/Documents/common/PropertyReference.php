<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
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
    public $supplierPropertyID;

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
            'vendorID' => ($property->supplierID === Supplier::ID_TRAVELGURU) ? ($property->tgrDetails->id ?? null) : $property->id,
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
            'supplierPropertyID' => $this->supplierPropertyID,
            'name' => $this->name,
            'starRating' => $this->starRating,
            'address' => toArrayOrNull($this->address),
        ]);
    }
}
