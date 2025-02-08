<?php

namespace SYSOTEL\OTA\Common\Services;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\Booking;
use SYSOTEL\OTA\Common\Helpers\Enums;

class BookingWebCheckInValidator
{
    protected Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * @return array{
     *     checkInAllowed: boolean,
     *     errorDescription: string
     * }
    */
    public function inspect(): array
    {
        $response = [
            'checkInAllowed' => true,
            'errorDescription' => ''
        ];

        if ($this->booking->status === Enums::BOOKING_STATUS_CANCELLED) {
            $response['errorDescription'] = 'Web check in is not allowed for cancelled booking';
        }

        else if ($this->booking->webCheckInDetails->status === Enums::BOOKING_WEB_CHECKIN_STATUS_COMPLETED) {
            $response['errorDescription'] = 'Web check in is already completed';
        }

        else if (!in_array($this->booking->status, [Enums::BOOKING_STATUS_CONFIRMED, Enums::BOOKING_STATUS_MODIFIED])) {
            $response['errorDescription'] = 'Web check in is not allowed for this booking';
        }

        else if(today()->gt($this->booking->stayDates->checkInDate)) {
            $response['errorDescription'] = 'Web check in is not after date of check in';
        }

        if($response['errorDescription']) {
            $response['checkInAllowed'] = false;
        }

        return $response;
    }

    /**
     * @return bool
     */
    public function isWebCheckInAllowed(): bool
    {
        return $this->inspect()['checkInAllowed'] === true;
    }
}