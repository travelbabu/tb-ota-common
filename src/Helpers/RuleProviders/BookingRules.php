<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\Booking;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\BookingCancellationDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\BookingRefund;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\BookingStatus;

class BookingRules
{
    /**
     * @return In
     */
    public static function validSource(): In
    {
        return new In([
            Booking::SOURCE_OFFLINE,
            Booking::SOURCE_OTA_DIRECT,
        ]);
    }

    public static function validBookingStatus(): In
    {
        return new In([
            BookingStatus::STATUS_FAILED,
            BookingStatus::STATUS_CONFIRMED,
            BookingStatus::STATUS_CANCELLED,
            BookingStatus::STATUS_MODIFIED,
            BookingStatus::STATUS_ATTEMPT,
            BookingStatus::STATUS_EXPIRED,
        ]);
    }

    public static function validRefundStatus(): In
    {
        return new In([
            BookingRefund::STATUS_INITIATE,
            BookingRefund::STATUS_CONFIRMED,
            BookingRefund::STATUS_FAILED,
        ]);
    }

    public static function validCancellationStatus(): In
    {
        return new In([
            BookingCancellationDetails::STATUS_INITIATED,
            BookingCancellationDetails::STATUS_PROCESSING,
            BookingCancellationDetails::STATUS_PROCESSED,
        ]);
    }

    public static function validRefundReason(): In
    {
        return new In([
            BookingRefund::REASON_ADJUSTMENT,
            BookingRefund::REASON_CANCELLATION,
        ]);
    }

    public static function validRefundMethod(): In
    {
        return new In([
            BookingRefund::METHOD_UNKNOWN,
            BookingRefund::METHOD_BANK_TRANSFER,
            BookingRefund::METHOD_CASH,
            BookingRefund::METHOD_CASHFREE_PG,
        ]);
    }
}
