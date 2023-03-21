<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\Helpers\Parsers\PropertyAddressParser;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class RawAddress extends EmbeddedDocument implements AddressContract
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $addressLine;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $area;

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
     * @var string
     * @ODM\Field(type="string")
     */
    public $country;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $postalCode;

    /**
     * @var GeoLocation
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation::class)
     */
    public $geoLocation;

    /**
     * Returns google map url for the address
     *
     * @return ?string
     */
    public function googleMapURL(): ?string
    {
        return isset($this->geoLocation)
            ? $this->geoLocation->googleMapURL()
            : null;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'addressLine'  => $this->addressLine,
            'area'         => $this->area,
            'city'         => $this->city,
            'state'        => $this->state,
            'country'      => $this->country,
            'geoLocation'  => $this->geoLocation->toArray(),
        ]);
    }

    public function getPostalCode(): string|null
    {
        return $this->postalCode;
    }

    public function getAddressLine(): string|null
    {
        return $this->addressLine;
    }

    public function getAreaName(): string|null
    {
        return $this->area;
    }

    public function getCityName(): string|null
    {
        return $this->city;
    }

    public function getStateName(): string|null
    {
        return $this->state;
    }

    public function getCountryName(): string|null
    {
        return $this->country;
    }

    /**
     * Returns address parser
     *
     * @return PropertyAddressParser
     */
    public function addressParser(): PropertyAddressParser
    {
        return (new PropertyAddressParser($this));
    }
}
