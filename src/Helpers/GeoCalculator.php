<?php

namespace SYSOTEL\OTA\Common\Helpers;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\BookingCancellationDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\BookingRefund;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Inquiry\Inquiry;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyContact\PropertyContact;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckInPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckOutPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\SpaceView;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

class GeoCalculator
{
    /**
     * https://www.geodatasource.com/developers/php
    */
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit= 'K')
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}
