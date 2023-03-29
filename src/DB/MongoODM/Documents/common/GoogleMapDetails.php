<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class GoogleMapDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $placeId;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $addr1;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $city;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $province;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $country;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $countryCode;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $postalCode;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $longitude;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $latitude;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $phone;

    /**
     * @var ?string[]
     * @ODM\Field(type="collection")
     */
    public $types;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $url;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'placeId' => $this->placeId,
            'name' => $this->name,
            'addr1' => $this->addr1,
            'city' => $this->city,
            'province' => $this->province,
            'country' => $this->country,
            'countryCode' => $this->countryCode,
            'postalCode' => $this->postalCode,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'phone' => $this->phone,
            'types' => $this->types,
            'url' => $this->url,
        ]);
    }
}
