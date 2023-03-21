<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDetails;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class NearbyPlace extends EmbeddedDocument
{
    use HasDefaultAttributes, HasTimestamps;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $distanceInKm;

    /**
     * @var GeoLocation
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\geoLocation::class)
     */
    public $geoLocation;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $sortOrder;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    protected $defaults = [
        'supplierID' => Supplier::ID_SELF,
        'sortOrder' => 0
    ];

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'supplierID' => $this->supplierID,
            'type' => $this->type,
            'name' => $this->name,
            'distanceInKm' => $this->distanceInKm,
            'geoLocation' => toArrayOrNull($this->geoLocation),
            'sortOrder' => $this->sortOrder,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);
    }
}
