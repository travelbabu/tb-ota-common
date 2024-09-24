<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class CategoryRating extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $category;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $ratingTopLine;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $ratingGiven;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $score;

    public function calculateScore(): float|int|null
    {
        if ($this->ratingTopLine !== null && $this->ratingGiven !== null) {
            // Ensure that ratingGiven is within the range of 0 to ratingTopLine
            $this->ratingGiven = max(0, min($this->ratingGiven, $this->ratingTopLine));
            return $this->score = (int)(($this->ratingGiven / $this->ratingTopLine) * 100);
        } else {
            return  $this->score = null;
        }
    }
    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
