<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Amenity;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Traits\Macroable;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelRepository;

/**
 * @ODM\EmbeddedDocument
 */
class ValueMeta extends EmbeddedDocument
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
    public $inputLabel;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $displayLabel;

    /**
     * @var ArrayCollection
     * @ODM\EmbedMany (targetDocument=AmenityTag::class)
     */
    public $tags;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'valueType'    => $this->valueType,
            'inputLabel'   => $this->inputLabel,
            'displayLabel' => $this->displayLabel,
            'tags'         => $this->tags->toArray(),
        ]);
    }
}
