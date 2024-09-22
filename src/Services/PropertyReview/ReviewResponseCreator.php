<?php

namespace SYSOTEL\OTA\Common\Services\PropertyReview;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\PropertyReview;

class ReviewResponseCreator
{
    private int $propertyId;

    public function __construct(int $propertyId)
    {
        $this->propertyId = $propertyId;
    }

    /**
     * @return array{reviews: PropertyReview[], summary: array}
     */
    public function get(): array
    {
        $reviews = PropertyReview::repository()->getActivePropertyReviews(
            $this->propertyId
        );

        $summaryCalculator = new ReviewSummaryCalculator($reviews);
        $summaryData = $summaryCalculator->generate();

        return [
            'reviews' => $reviews,
            'summary' => $summaryData,
        ];
    }
}
