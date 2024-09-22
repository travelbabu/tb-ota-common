<?php

namespace SYSOTEL\OTA\Common\Services\PropertyReview;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\PropertyReview;
use SYSOTEL\OTA\Common\Enums\ReviewCategory;
use function SYSOTEL\OTA\Common\Helpers\isPositiveNumber;

class ReviewSummaryCalculator
{
    /**
     * @var PropertyReview[]
     */
    private array $reviews;

    public function __construct(array $reviews)
    {
        $this->reviews = $reviews;
    }

    public function generate(): array
    {
        $overallRatingsData = [
            'ratingCount' => 0,
            'ratings' => []
        ];
        $categoryRatingsData = [];

        foreach(ReviewCategory::cases() as $reviewCategory) {
            $categoryRatingsData[$reviewCategory->value] = [
                'category' => $reviewCategory->value,
                'categoryLabel' => $reviewCategory->label(),
                'ratingCount' => 0,
                'ratings' => []
            ];
        }

        foreach($this->reviews as $review) {
            if(!isset($review->rating->ratingGiven)) {
                continue;
            }

            $overallRatingsData['ratingCount']++;
            $overallRatingsData['ratings'][] = [
                'ratingGiven' => $review->rating->ratingGiven
            ];

            foreach($review->rating->categoryRatings as $categoryRating) {
                if(!isset($categoryRating->ratingGiven)) {
                    continue;
                }

//                if(!isset($categoryRatingsData[$categoryRating->category->value])) {
//                    $categoryRatingsData[$categoryRating->category->value] = [
//                        'category' => $categoryRating->category->value,
//                        'categoryLabel' => $categoryRating->category->label(),
//                        'ratingCount' => 0,
//                        'ratings' => []
//                    ];
//                }

                $categoryRatingsData[$categoryRating->category->value]['ratingCount']++;
                $categoryRatingsData[$categoryRating->category->value]['ratings'][] = [
                    'ratingGiven' => $categoryRating->ratingGiven
                ];
            }
        }

        $allOverallRatingGivenSum = 0;
        foreach($overallRatingsData['ratings'] as $overallRatingsDataItem) {
            $allOverallRatingGivenSum += $overallRatingsDataItem['ratingGiven'];
        }

        $summary = [
            'ratingTopLine' => 5,
            'ratingGiven' => 0,
            'ratingLabel' => '',
            'ratingCount' => count($overallRatingsData['ratings']),
            'categories' => []
        ];

        if(isPositiveNumber($allOverallRatingGivenSum)) {
            $summary['ratingGiven'] = round($allOverallRatingGivenSum / count($overallRatingsData['ratings']), 1);
            $summary['ratingLabel'] = RatingLabelGenerator::generate($summary['ratingGiven']);
        }

        foreach($categoryRatingsData as $categoryDataItem) {
            $categoryRatingGivenSum = 0;
            foreach($categoryDataItem['ratings'] as $categoryRatingDataItem) {
                $categoryRatingGivenSum += $categoryRatingDataItem['ratingGiven'];
            }

            $categorySummaryData = [
                'category' => $categoryDataItem['category'],
                'categoryLabel' => $categoryDataItem['categoryLabel'],
                'ratingTopLine' => 5,
                'ratingGiven' => 0,
                'ratingLabel' => '',
                'ratingCount' => count($categoryDataItem['ratings'])
            ];

            if(isPositiveNumber($categoryRatingGivenSum)) {
                $categorySummaryData['ratingGiven'] = round($categoryRatingGivenSum / count($categoryDataItem['ratings']), 1);
                $categorySummaryData['ratingLabel'] = RatingLabelGenerator::generate($categorySummaryData['ratingGiven']);
            }

            $summary['categories'][] = $categorySummaryData;
        }

        return $summary;
    }
}
