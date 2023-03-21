<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Amenity;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Traits\Macroable;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelRepository;

/**
 * @ODM\EmbeddedDocument
 */
class AmenityTag extends EmbeddedDocument
{
    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $valueType;
    public const VALUE_TYPE_TAG = 'TAG';
    public const VALUE_TYPE_TAGS = 'TAGS';
    public const VALUE_TYPE_CHARGES = 'CHARGES';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $valueLabel;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $meta;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $sortOrder;



    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'                => $this->id,
            'displayName'       => $this->displayName,
            'vendor'            => $this->vendor,
            'segment'           => $this->segment,
            'status'            => $this->status,
            'type'              => $this->type,
            'isInternal'        => $this->isInternal,
            'apiPayloadFormat'  => $this->apiPayloadFormat,
            'createdAt'         => $this->createdAt,
            'updatedAt'         => $this->updatedAt,
        ]);
    }
}
