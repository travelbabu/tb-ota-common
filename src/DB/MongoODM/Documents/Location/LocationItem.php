<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location;

use Delta4op\MongoODM\Documents\Document;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\MappedSuperclass
 */
abstract class LocationItem extends Document
{
    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field
     */
    public $slug;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var GeoLocation
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation::class)
     */
    public $geoLocation;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $searchKeywords;

    /**
     * @var AllSupplierDetails
     * @ODM\EmbedOne(targetDocument=AllSupplierDetails::class)
     */
    public $supplierDetails;

    /**
     * @var PropertyCount
     * @ODM\EmbedOne(targetDocument=PropertyCount::class)
     */
    public $propertyCount;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';

    public function __construct(array $attributes = [])
    {
        $this->searchKeywords = [];
        $this->propertyCount = new PropertyCount;
        $this->supplierDetails = new AllSupplierDetails;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'              => $this->id,
            'slug'            => $this->slug,
            'name'            => $this->name,
            'status'          => $this->status,
            'geoLocation'     => toArrayOrNull($this->geoLocation),
            'searchKeywords'  => $this->searchKeywords,
            'propertyCount'  => toArrayOrNull($this->propertyCount),
        ]);
    }
}
