<?php

namespace SYSOTEL\OTA\Common\Helpers;

use Carbon\Carbon;
use Delta4op\MongoODM\DocumentManagers\DocumentManager;
use Delta4op\MongoODM\DocumentManagers\TransactionalDocumentManager;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use MongoDB\BSON\UTCDateTime;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AdminSetting\AdminSetting;

if (!function_exists('googleMapURL')) {
    /**
     * Constructrs and returns google map url
     *
     * @param $latitude
     * @param $longitude
     * @return string
     */
    function googleMapURL($latitude, $longitude): string
    {
        return "https://maps.google.com/maps?q=$latitude,$longitude";
    }
}

if (!function_exists('documentManager')) {
    /**
     * Shortcut to get document manager
     *
     * @return DocumentManager
     */
    function documentManager(): DocumentManager
    {
        return app('DocumentManager');
    }
}

if (!function_exists('transactionalDocumentManager')) {
    /**
     * Shortcut to get document manager
     *
     * @return TransactionalDocumentManager
     */
    function transactionalDocumentManager(): TransactionalDocumentManager
    {
        return app('TransactionalDocumentManager');
    }
}

if (!function_exists('secondsToHumanReadableTime')) {
    /**
     * Converts seconds to human-readable time
     *
     *
     * @source https://jonlabelle.com/snippets/view/php/convert-seconds-to-human-readable
     */
    function secondsToHumanReadableTime(int $seconds): string
    {
        $periods = array(
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60,
            'second' => 1
        );

        $parts = array();

        foreach ($periods as $name => $dur) {
            $div = floor($seconds / $dur);

            if ($div == 0)
                continue;
            else
                if ($div == 1)
                    $parts[] = $div . " " . $name;
                else
                    $parts[] = $div . " " . $name . "s";
            $seconds %= $dur;
        }

        $last = array_pop($parts);

        if (empty($parts))
            return $last;
        else
            return join(', ', $parts) . " and " . $last;
    }
}

if (!function_exists('millisecondsToSeconds')) {
    /**
     * Milliseconds to seconds converter
     *
     * @param int $milliseconds
     * @return float
     * @author Ravish
     */
    function millisecondsToSeconds(int $milliseconds): float
    {
        return round($milliseconds / 1000, 2);
    }
}

if (!function_exists('millisecondsToHumanReadableTime')) {
    /**
     * Milliseconds to human-readable time
     *
     * @param int $milliseconds
     * @return string
     * @author Ravish
     */
    function millisecondsToHumanReadableTime(int $milliseconds): string
    {
        return secondsToHumanReadableTime(
            millisecondsToSeconds($milliseconds)
        );
    }
}

if (!function_exists('utcDateTimeToString')) {
    function utcDateTimeToString(UTCDateTime $date, $format = null): string
    {
        $format = $format ?? READABLE_DATE_TIME_FORMAT;

        return utcDateTimeToCarbon($date)->format($format);
    }
}

if (!function_exists('UTCDateTimeToCarbon')) {
    /**
     * Create Carbon object from UTCDateTime object
     *
     * @param UTCDateTime $date
     * @return Carbon
     * @author Ravish
     */
    function UTCDateTimeToCarbon(UTCDateTime $date): Carbon
    {
        return Date::createFromTimestampMs($date->toDateTime()->format('Uv'));
    }
}

if (!function_exists('carbonToUTCDateTime')) {
    /**
     * Create UTCDateTime object from Carbon object
     *
     * @param Carbon $carbon
     * @return UTCDateTime
     * @author Ravish
     */
    function carbonToUTCDateTime(Carbon $carbon): UTCDateTime
    {
        return new UTCDateTime($carbon);
    }
}

if (!function_exists('generateRandomNumber')) {
    /**
     * Generate random number of given length
     *
     * @throws Exception
     * @aurhor Ravish
     */
    function generateRandomNumber($length): int
    {
        $min = 10;
        foreach (range(1, $length) as $i) {
            $min *= 10;
        }

        $max = ($min * 10) - 1;

        return random_int($min, $max);
    }
}

if (!function_exists('isProductionEnvironment')) {
    /**
     * Returns true if app is running in production environment
     *
     * @return bool
     * @aurhor Ravish
     */
    function isProductionEnvironment(): bool
    {
        return app()->environment('production');
    }
}

if (!function_exists('arrayFilter')) {
    /**
     * Returns true if app is running in production environment
     *
     * @param array $array
     * @return array
     * @aurhor Ravish
     */
    function arrayFilter(array $array): array
    {
        return array_filter($array, function ($value) {
            return isset($value);
        });
    }
}

if (!function_exists('dateWindows')) {
    /**
     * Method to create date ranges between $startDateString and $endDateString, including only date specified
     * Converts startdate and enddate to carbon objects
     * loop throgh the date range and pick dates that is of the day specified in
     * @param string $startDateString
     * @param string $endDateString
     * @param array $days
     *
     * @return array @author Ravish
     */
    function dateWindows(string $startDateString, string $endDateString, array $days): array
    {
        if (count($days) < 1) return [];

        $startDate = Carbon::parse($startDateString);
        $endDate = Carbon::parse($endDateString);

        $dateArray = [];
        for ($d = $startDate->copy(); $d->lte($endDate); $d->addDay()) {
            if (in_array($d->dayOfWeek, $days))
                $dateArray[] = $d->copy();
        }


        $dateRangeArray = [];
        $x = null;
        foreach ($dateArray as $i => $currentDate) {
            if ($i < $x) continue;
            $x = $i + 1;
            $endDate = $currentDate->copy();
            foreach (array_slice($dateArray, $i + 1) as $j => $date2) {
                if ($endDate->diff($date2, false)->days == 1) {
                    $endDate->addDays(1);
                    $x++;
                } else {
                    break;
                }
            }

            $dateRangeArray[] = [
                'start_date' => $currentDate->toDateString(),
                'end_date' => $endDate->toDateString(),
            ];
        }

        return $dateRangeArray;
    }
}

if (!function_exists('dateArray')) {
    /**
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return Carbon[]
     */
    function dateArray(Carbon $startDate, Carbon $endDate): array
    {
        // replace dates if not in correct order
        if ($startDate->gt($endDate)) {
            $temp = $endDate->clone();
            $endDate = $startDate->clone();
            $startDate = $temp;
        }

        $dateArray = [];
        for ($d = $startDate->copy(); $d->lte($endDate); $d->addDay()) {
            $dateArray[] = $d->copy();
        }

        return $dateArray;
    }
}

if (!function_exists('trimUnderscores')) {

    /**
     * @param string $value
     * @return string
     */
    function trimUnderscores(string $value): string
    {
        return Str::replace('_', ' ', $value);
    }
}

if (!function_exists('constantToCamelCase')) {

    /**
     * @param string $value
     * @return string
     */
    function constantToCamelCase(string $value): string
    {
        return ucwords(strtolower(Str::replace('_', ' ', $value)));
    }
}

if (!function_exists('toArrayOrNull')) {

    /**
     * @param Arrayable|null $arrayable
     * @return array|null
     */
    function toArrayOrNull(Arrayable $arrayable = null): ?array
    {
        return isset($arrayable) ? $arrayable->toArray() : null;
    }
}

if (!function_exists('getAdminSetting')) {
    /**
     * @param string $id
     * @param null $default
     * @param bool $strictMode
     * @return mixed
     * @throws Exception
     */
    function getAdminSetting(string $id, $default = null, bool $strictMode = false): mixed
    {
        $setting = AdminSetting::repository()->find($id);

        if(!$setting && $strictMode) {
            throw new Exception('Admin settings not found for id ' . $id);
        }

        return $setting->value ?? $default;
    }
}

if (!function_exists('constantToReadableString')) {
    /**
     * @param string $str
     * @return mixed
     */
    function constantToReadableString(string $str): mixed
    {
        return ucwords(strtolower(str_replace('_', ' ', $str)));
    }
}