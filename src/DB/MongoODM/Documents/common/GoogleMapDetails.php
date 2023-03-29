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
    protected $placeId;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $addr1;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $city;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $province;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $country;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $countryCode;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $postalCode;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    protected $longitude;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    protected $latitude;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $phone;

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
        ]);
    }

    /**
     * @return string|null
     */
    public function getPlaceId(): ?string
    {
        return $this->placeId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getAddr1(): ?string
    {
        return $this->addr1;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }
}
