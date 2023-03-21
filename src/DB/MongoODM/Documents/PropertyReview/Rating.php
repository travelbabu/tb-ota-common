<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyReview;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class Rating extends EmbeddedDocument
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $overallScore;

    /**
     * @var AllRatings
     * @ODM\EmbedOne(targetDocument=AllRatings::class)
    */
    public $ratingDetails;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'overallScore'  => $this->overallScore,
        ]);
    }
}
