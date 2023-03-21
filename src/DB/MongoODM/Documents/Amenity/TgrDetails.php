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
class TgrDetails extends EmbeddedDocument
{
    /**
     * @var TgrAmenity
     * @ODM\EmbedMany(targetDocument=TgrAmenity::class)
     */
    public $amenities;

    public function __construct(array $attributes = [])
    {
        $this->amenities = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'amenities' => collect($this->amenities)->toArray(),
        ]);
    }

    /**
     * User Repository
     *
     * @return ChannelRepository
     */
    public static function repository(): ChannelRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
