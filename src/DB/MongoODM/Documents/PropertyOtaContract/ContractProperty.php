<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyOtaContract;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ContractProperty extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $address;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $starRating;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $city;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $state;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $postalCode;

    public static function createFromProperty(Property $property): ContractProperty
    {
        return new self([
            'name' => $property->displayName,
            'starRating' => $property->starRating,
            'address' => $property->address->addressParser()->fullAddress(),
            'city' => $property->address->city->name,
            'state' => $property->address->state->name,
            'postalCode' => $property->address->postalCode,
        ]);
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'name' => $this->name,
            'address' => $this->address,
            'starRating' => $this->starRating,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
        ]);
    }
}
