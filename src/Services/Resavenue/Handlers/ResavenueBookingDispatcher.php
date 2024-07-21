<?php

namespace SYSOTEL\OTA\Common\Services\Resavenue\Handlers;

use App\DB\Models\ChannelLogs\PushBookingLog\PushBookingLog;
use App\DB\Models\embedded\BookingReference;
use App\DB\Models\embedded\PropertyReference;
use App\DB\Models\PropertyChannelSettings\PropertyChannelSettings;
use App\Enums\BookingPushActionType;
use App\Enums\ChannelId;
use App\Enums\ChannelLogStatus;
use App\Services\ChannelServices\Contracts\BookingDispatcherContract;
use SYSOTEL\APP\BE\Common\Mongo\Documents\Booking\Booking;

class ResavenueBookingDispatcher implements BookingDispatcherContract
{
    public function __construct(
        protected Booking $booking,
        protected BookingPushActionType $actionType,
        protected PropertyChannelSettings $channelSettings
    ){}

    /**
     * @return PushBookingLog
     */
    public function prepareLog(): PushBookingLog
    {
        $log = new PushBookingLog();
        $log->channelSettingsId = $this->channelSettings->id;
        $log->channelId = ChannelId::RESAVENUE;
        $log->status = ChannelLogStatus::PENDING;

        $propertyReference = new PropertyReference;
        $propertyReference->id = $this->booking->getProperty()?->getId();
        $propertyReference->displayName = $this->booking->getProperty()?->getDisplayName();
        $log->property()->associate($propertyReference);

        $bookingReference = new BookingReference;
        $bookingReference->_id = $this->booking->getId();
        $bookingReference->actionType = $this->actionType;
        $bookingReference->status = $this->booking->getStatus()?->getValue();
        $log->booking()->associate($bookingReference);

        $log->save();

        return $log;
    }

    public function getChannelId(): ChannelId
    {
        return ChannelId::RESAVENUE;
    }

    /**
     * @return Booking
     */
    public function getBooking(): Booking
    {
        return $this->booking;
    }

    /**
     * @return PropertyChannelSettings
     */
    public function getChannelSettings(): PropertyChannelSettings
    {
        return $this->channelSettings;
    }
}
