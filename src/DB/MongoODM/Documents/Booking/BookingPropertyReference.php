<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation;

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
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
