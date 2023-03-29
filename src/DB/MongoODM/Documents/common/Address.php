<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\Helpers\Parsers\PropertyAddressParser;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class Address extends EmbeddedDocument implements AddressContract
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $addressLine;

    /**
     * @var AreaReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\AreaReference::class)
     */
    public $area;

    /**
     * @var CityReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CityReference::class)
     */
    public $city;

    /**
     * @var StateReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\StateReference::class)
     */
    public $state;

    /**
     * @var CountryReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CountryReference::class)
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
     * @var GoogleMapDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GoogleMapDetails::class)
     */
    public $googleMapDetails;

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
            'area'         => toArrayOrNull($this->area),
            'city'         => toArrayOrNull($this->city),
            'state'        => toArrayOrNull($this->state),
            'country'      => toArrayOrNull($this->country),
            'geoLocation'  => toArrayOrNull($this->geoLocation),
            'googleMapDetails'  => toArrayOrNull($this->googleMapDetails),
        ]);
    }

    public function getAddressLine(): ?string
    {
        return $this->addressLine ?? null;
    }

    public function getAreaName(): ?string
    {
        return $this->area->name ?? null;
    }

    public function getCityName(): ?string
    {
        return $this->city->name ?? null;
    }

    public function getStateName(): ?string
    {
        return $this->state->name ?? null;
    }

    public function getCountryName(): ?string
    {
        return $this->country->name ?? null;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode ?? null;
    }

    /**
     * @return GoogleMapDetails
     */
    public function getGoogleMapDetails(): GoogleMapDetails
    {
        return $this->googleMapDetails;
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
