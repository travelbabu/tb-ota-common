<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Location;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;

/**
 * @ODM\EmbeddedDocument
 */
class BookingPropertyReference extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $displayName;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $starRating;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $baseCurrency;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $fullAddress;

    /**
     * @var Location|null
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Location::class)
     */
    public $geoLocation;

    /**
     * @var ?string
     * @ODM\Field(type="object_id")
     */
    public $areaId;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $areaName;

    /**
     * @var ?string
     * @ODM\Field(type="object_id")
     */
    public $cityId;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $cityName;

    /**
     * @var ?string
     * @ODM\Field(type="object_id")
     */
    public $stateId;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $stateName;

    /**
     * @var ?string
     * @ODM\Field(type="object_id")
     */
    public $countryId;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $countryName;

    /**
     * @param Property $property
     * @return static
     */
    public static function createFromProperty(Property $property): static
    {
        return new static([
            'id' => $property->id,
            'baseCurrency' => $property->baseCurrency,
            'starRating' => $property->starRating,
            'fullAddress' => $property->address?->addressParser()?->fullAddress() ?? $property->rawAddress?->addressParser()?->fullAddress(),
            'areaId' => $property->address?->area?->id ?? $property->rawAddress?->area,
            'areaName' => $property->address?->area?->name,
            'cityId' => $property->address?->city?->id ?? $property->rawAddress?->city,
            'cityName' => $property->address?->city?->name,
            'stateId' => $property->address?->state?->id,
            'stateName' => $property->address?->state?->name ?? $property->rawAddress?->state,
            'countryId' => $property->address?->country?->id,
            'countryName' => $property->address?->country?->name ?? $property->rawAddress?->country,
            'location' => $property->address?->geoLocation?->location,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
