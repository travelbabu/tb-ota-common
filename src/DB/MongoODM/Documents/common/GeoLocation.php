<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class GeoLocation extends EmbeddedDocument
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $latitude;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $longitude;

    /**
     * @var Location
     * @ODM\EmbedOne (targetDocument=Location::class)
     */
    public $location;

    /**
     * @ODM\PrePersist
    */
    public function prePersist()
    {
        $this->setLocation();
    }

    /**
     * @ODM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setLocation();
    }

    public function setLocation()
    {
        if(!$this->latitude || !$this->longitude) {
            abort(500, 'Cannot set location without latitude and longitude values');
        }

        $this->location = new Location([
            'type' => 'Point',
            'coordinates' => [(float)$this->longitude, (float) $this->latitude]
        ]);
    }

    /**
     * Returns google map url for the address
     *
     * @return string
     */
    public function googleMapURL(): string
    {
        return "https://maps.google.com/maps?q={$this->latitude},{$this->longitude}";
    }

    public function googleMapIframeUrl($zoom = 14)
    {
        return "https://maps.google.com/maps?q={$this->latitude},{$this->longitude}&hl=es&z={$zoom}&output=embed";
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
        ]);
    }
}
