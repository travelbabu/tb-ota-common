<?php

namespace SYSOTEL\OTA\Common\Services\Resavenue;

use Carbon\Carbon;
use App\Enums\AgeCode;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\DB\Models\ChannelLogs\UpdateRateLog\embedded\CriteriaItem;
use SYSOTEL\APP\ApiConnector\CmsOpenApi\Data\Space\common\SpaceOccupancy;

class ResavenueHelpers
{
    /**
     * @param array $daySelection
     * @return array
     */
    public static function daysDataToApplicableDays(array $daySelection): array
    {
        $applicableDays = [];

        if (($daySelection["Mon"] ?? null) === "True") {
            $applicableDays[] = 1;
        }
        if (($daySelection["Tue"] ?? null) === "True") {
            $applicableDays[] = 2;
        }
        if (($daySelection["Weds"] ?? null) === "True") {
            $applicableDays[] = 3;
        }
        if (($daySelection["Thur"] ?? null) === "True") {
            $applicableDays[] = 4;
        }
        if (($daySelection["Fri"] ?? null) === "True") {
            $applicableDays[] = 5;
        }
        if (($daySelection["Sat"] ?? null) === "True") {
            $applicableDays[] = 6;
        }
        if (($daySelection["Sun"] ?? null) === "True") {
            $applicableDays[] = 0;
        }

        return $applicableDays;
    }

    /**
     * @return string
     */
    public static function getTargetValue(): string
    {
        if (config('app.env') == 'production') {
            return 'Production';
        } else {
            return 'Testing';
        }
    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @return void
     */
    public static function validateUpdateDateRange(Carbon $start, Carbon $end): void
    {
        if (!($end->gte($start))) {
            throw new HttpException(404, 'End Date should be greater than or equal to startDate');
        }

        if ($end->diffInDays($start) > 365) {
            throw new HttpException(404, 'The difference between two date should not be greater than 1 year');
        }
    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @return void
     */
    public static function validateFetchDataRange(Carbon $start, Carbon $end): void
    {
        if (!($end->gte($start))) {
            throw new HttpException(404, 'End Date should be greater than or equal to startDate');
        }

        if ($end->diffInDays($start) > 90) {
            throw new HttpException(404, 'The difference between two date should not be more than 3 months');
        }
    }

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @return void
     */
    public static function validateFetchBookingDataRange(Carbon $start, Carbon $end): void
    {
        if ($end->diffInDays($start) > 90) {
            throw new HttpException(404, 'The difference between two date should not be more than 3 months');
        }
    }

    /**
     * @return string
     */
    public static function getRequestDateFormat(): string
    {
        return config('channel-connectivity.resavenue.request_date_format');
    }

    /**
     * @return string
     */
    public static function getRequestDateFormatRule(): string
    {
        return 'date_format:' . self::getRequestDateFormat();
    }

    /**
     * @return string
     */
    public static function getResponseDateFormat(): string
    {
        return config('channel-connectivity.resavenue.response_date_format');
    }

    /**
     * @return string
     */
    public static function getRequestTimestampFormat(): string
    {
        return config('channel-connectivity.resavenue.request_timestamp_format');
    }

    /**
     * @return string
     */
    public static function getRequestTimestampFormatRule(): string
    {
        return 'date_format:' . self::getRequestTimestampFormat();
    }

    /**
     * @return string
     */
    public static function getResponseTimestampFormat(): string
    {
        return config('channel-connectivity.resavenue.response_timestamp_format');
    }

    /**
     * @return string
     */
    public static function getRequestTimestamp(): string
    {
        return config('channel-connectivity.resavenue.request_timestamp_format2');
    }

    /**
     * @return string
     */
    public static function getRequestTimestampRule(): string
    {
        return 'date_format:' . self::getRequestTimestamp();
    }

    /**
     * @return string
     */
    public static function getResponseTimestamp(): string
    {
        return config('channel-connectivity.resavenue.response_timestamp_format2');
    }

    /**
     * @return string
     */
    public static function getResponseTimestampRule(): string
    {
        return 'date_format:' . self::getResponseTimestamp();
    }

    /**
     * @return string
     */
    public static function booleanStringRule(): string
    {
        return 'in:True,False';
    }

    /**
     * @param string $date
     * @return Carbon
     */
    public static function dateToCarbonInstance(string $date): Carbon
    {
        return Carbon::createFromFormat(config('channel-connectivity.resavenue.request_date_format'), $date);
    }

    /**
     * @param string $timeStamp
     * @return Carbon
     */
    public static function timestamp1ToCarbonInstance(string $timeStamp): Carbon
    {
        return Carbon::createFromFormat(config('channel-connectivity.resavenue.request_timestamp_format'), $timeStamp);
    }

    /**
     * @param string $timeStamp
     * @return Carbon
     */
    public static function timestamp2ToCarbonInstance(string $timeStamp): Carbon
    {
        return Carbon::createFromFormat(config('channel-connectivity.resavenue.request_timestamp_format2'), $timeStamp);
    }

    /**
     * @param CriteriaItem $criteria
     * @param SpaceOccupancy $occupancy
     * @return void
     */
    public static function checkRateEntirety(CriteriaItem $criteria, SpaceOccupancy $occupancy): void
    {
        $requireBaseRateCounts = $occupancy->baseRateCounts;
        $requiredRatesString = '';
        $hasRequiredBaseRates = true;
        $hasRequiredExtraRates = true;

        foreach ($occupancy->baseRateCounts as $baseRateCount) {
            $requiredRatesString .= "Base-Rate-$baseRateCount ";
        }

        $giveBaseRateCounts = [];
        foreach (($criteria->rates?->baseRates ?? []) as $baseRate) {
            $giveBaseRateCounts[] = $baseRate->count;
        }

        if (array_diff($requireBaseRateCounts, $giveBaseRateCounts) !== []) {
            $hasRequiredBaseRates = false;
        }


        if ($occupancy->isExtraAdultAllowed) {
            $requiredRatesString .= 'Extra Adult ';
            if (!$criteria->rates->getExtraRateItem(1, AgeCode::ADULT)) {
                $hasRequiredExtraRates = false;
            }
        }

        if ($occupancy->isExtraChildAllowed) {
            $requiredRatesString .= 'Extra Child ';
            if (!$criteria->rates->getExtraRateItem(1, AgeCode::CHILD)) {
                $hasRequiredExtraRates = false;
            }
        }

        $requiredRatesString = trim($requiredRatesString);

        if (!$hasRequiredBaseRates || !$hasRequiredExtraRates) {
            throw new HttpException(400, 'Rate didnt match the entirety. Required rates - ' . $requiredRatesString);
        }
    }
}
