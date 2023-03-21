<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyReview;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class AllRatings extends EmbeddedDocument
{
    /**
     * @var RatingItem
     * @ODM\EmbedOne (targetDocument=RatingItem::class)
     */
    public $roomQuality;

    /**
     * @var RatingItem
     * @ODM\EmbedOne (targetDocument=RatingItem::class)
     */
    public $service;

    /**
     * @var RatingItem
     * @ODM\EmbedOne (targetDocument=RatingItem::class)
     */
    public $food;

    /**
     * @var RatingItem
     * @ODM\EmbedOne (targetDocument=RatingItem::class)
     */
    public $cleanliness;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'roomQuality'  => toArrayOrNull($this->roomQuality),
            'service'  => toArrayOrNull($this->service),
            'food'  => toArrayOrNull($this->food),
            'cleanliness'  => toArrayOrNull($this->cleanliness),
        ]);
    }
}
