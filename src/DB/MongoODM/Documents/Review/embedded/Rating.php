<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\embedded;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class Rating extends EmbeddedDocument
{
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

    /**
     * @var ArrayCollection & CategoryRating[]
     * @ODM\EmbeddedDocument (targetDocument=CategoryRating::class)
     */
    public $categoryRatings;

    public function __construct(array $attributes = [])
    {
        $this->categoryRatings = new ArrayCollection;

        parent::__construct($attributes);
    }

    public function calculateRating(): static
    {
        $this->ratingTopLine = 5;
        $totalRatingGiven = 0;
        $totalScore = 0;

        $categoryCount = $this->categoryRatings->count();
        foreach ($this->categoryRatings as $categoryRating) {
            $totalRatingGiven += $categoryRating->ratingGiven ?? 0;
            $totalScore += $categoryRating->score ?? 0;
        }

        $this->ratingGiven = $categoryCount > 0 ? round($totalRatingGiven / $categoryCount, 1) : 0;
        $this->score = $categoryCount > 0 ?  (int)round($totalScore / $categoryCount, 1) : 0;

        return $this;
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
