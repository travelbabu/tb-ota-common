<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyReview;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class RatingItem extends EmbeddedDocument
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $score;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $comment;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'score'  => $this->score,
            'comment'  => $this->comment,
        ]);
    }
}
