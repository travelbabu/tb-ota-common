<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation;
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
    protected $id;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $displayName;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    protected $starRating;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $baseCurrency;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $fullAddress;

    /**
     * @var GeoLocation|null
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation::class)
     */
    protected $geoLocation;

    /**
     * @var ?string
     * @ODM\Field(type="object_id")
     */
    protected $areaId;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $areaName;

    /**
     * @var ?string
     * @ODM\Field(type="object_id")
     */
    protected $cityId;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $cityName;

    /**
     * @var ?string
     * @ODM\Field(type="object_id")
     */
    protected $stateId;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $stateName;

    /**
     * @var ?string
     * @ODM\Field(type="object_id")
     */
    protected $countryId;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $countryName;

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
            'fullAddress' => $property->address->addressParser()->fullAddress(),
            'areaId' => $property->address->area->id,
            'areaName' => $property->address->area->name,
            'cityId' => $property->address->city->id,
            'cityName' => $property->address->city->name,
            'stateId' => $property->address->state->id,
            'stateName' => $property->address->state->name,
            'countryId' => $property->address->country->id,
            'countryName' => $property->address->country->name,
            'geoLocation' => $property->address->geoLocation,
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
