<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;

/**
 * @ODM\EmbeddedDocument
 */
class InventoryUpdateLog extends EmbeddedDocument
{
    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $id;

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
     * @var Carbon
     * @ODM\Field (type="carbon")
     */
    public $timestamp;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'count' => $this->count,
            'type' => $this->type,
            'timestamp' => $this->timestamp,
        ];
    }
}
