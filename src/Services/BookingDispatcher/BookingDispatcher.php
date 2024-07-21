<?php

namespace SYSOTEL\OTA\Common\Services\BookingDispatcher;

use Doctrine\ODM\MongoDB\MongoDBException;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\Booking;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity\ChannelConnectivity;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\ChannelLogAttemptDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\ChannelLogProperty;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\ProvideBookings\ProvideBookingsLog;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ChannelConnectivityReference;
use SYSOTEL\OTA\Common\Helpers\Enums;
use function SYSOTEL\OTA\Common\Helpers\documentManager;

class BookingDispatcher
{
    private Booking $booking;

    private array $supportedChannelIDs = [
        Enums::CHANNEL_ID_RESAVENUE
    ];

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * @return ProvideBookingsLog|null
     * @throws MongoDBException
     */
    public function dispatch(): ProvideBookingsLog|null
    {
        $channelConnectivity = ChannelConnectivity::repository()->findOneBy([
            'propertyID' => $this->booking->property->id,
            'channelID' => ['$in' => $this->supportedChannelIDs],
            'isExpired' => false,
            'status' => Enums::CHANNEL_CONNECTIVITY_STATUS_ACTIVE
        ]);

        if (!$channelConnectivity) {
            return null;
        }

        $pushBookingLog = new ProvideBookingsLog([
            'channelID' => Enums::CHANNEL_ID_RESAVENUE,
            'property' => new ChannelLogProperty([
                'id' => $this->booking->property->id,
                'name' => $this->booking->property->displayName,
            ]),
            'attemptDetails' => new ChannelLogAttemptDetails,
            'connectivity' => ChannelConnectivityReference::createFromConnectivity($channelConnectivity),
            'status' => Enums::CHANNEL_LOG_STATUS_PENDING
        ]);

        documentManager()->persist($pushBookingLog);
        documentManager()->flush();

        return $pushBookingLog;
    }
}