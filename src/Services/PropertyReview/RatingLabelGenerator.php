<?php

namespace SYSOTEL\OTA\Common\Services\PropertyReview;

class RatingLabelGenerator
{
    /**
     * @param float|null $rating
     * @return string
     */
    public static function generate(?float $rating): string
    {
        if($rating < 1) {
            return 'Poor';
        }

        if($rating < 2) {
            return 'Bad';
        }

        if($rating < 3) {
            return 'Good';
        }

        if($rating < 4) {
            return 'Very Good';
        }

        if($rating <= 5) {
            return 'Excellent';
        }

        return '';
    }
}
