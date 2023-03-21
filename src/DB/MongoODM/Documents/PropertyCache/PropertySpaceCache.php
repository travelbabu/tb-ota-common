<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCache;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\SpaceAvatar;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\SpaceView;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\TgrDetails;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class PropertySpaceCache extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $displayName;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $baseOccupancy;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $maxOccupancy;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $maxExtraBeds;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isChildAllowed;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $supportedRates;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $sortOrder;

    /**
     * @var TgrDetails
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\TgrDetails::class)
     */
    public $tgrDetails;

    /**
     * @var SpaceView
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\SpaceView::class)
     */
    public $view;

    /**
     * @var ?SpaceAvatar
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\SpaceAvatar::class)
     */
    public $avatar;

    /**
     * @var ArrayCollection & PropertyImageCache[]
     * @ODM\EmbedMany (targetDocument=PropertyImageCache::class)
     */
    public $images;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->images = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @return PropertySpace
     */
    public function createDummySpaceDocument(): PropertySpace
    {
        return new PropertySpace([
            'id' => $this->id,
            'supplierID' => $this->supplierID,
            'propertyID' => $this->propertyID,
            'displayName' => $this->displayName,
            'baseOccupancy' => $this->baseOccupancy,
            'maxOccupancy' => $this->maxOccupancy,
            'maxExtraBeds' => $this->maxExtraBeds,
            'isChildAllowed' => $this->isChildAllowed,
            'supportedRates' => $this->supportedRates,
            'sortOrder' => $this->sortOrder,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'                => $this->id,
            'displayName'       => $this->displayName,
            'noOfUnits'         => $this->noOfUnits,
            'baseOccupancy'     => $this->baseOccupancy,
            'maxOccupancy'      => $this->maxOccupancy,
            'maxExtraBeds'      => $this->maxExtraBeds,
            'isChildAllowed'    => $this->isChildAllowed,
            'supportedRates'    => $this->supportedRates,
            'view'              => toArrayOrNull($this->view),
            'avatar'            => toArrayOrNull($this->avatar),
            'tgrDetails'        => toArrayOrNull($this->tgrDetails),
            'images'            => collect($this->images)->toArray()
        ]);
    }
}
