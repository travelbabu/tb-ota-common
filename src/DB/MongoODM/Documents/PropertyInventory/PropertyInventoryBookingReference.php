<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyInventory;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyInventoryBookingReference extends EmbeddedDocument
{
    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $globalID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $bookingID;


    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $count;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_OPEN = 'OPEN';
    public const TYPE_CLOSE = 'CLOSE';

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'globalID' => $this->globalID,
            'bookingID' => $this->bookingID,
            'type' => $this->type,
            'count' => $this->count,
        ];
    }
}
