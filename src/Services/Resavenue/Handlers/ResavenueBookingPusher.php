<?php

namespace SYSOTEL\OTA\Common\Services\Resavenue\Handlers;

use App\DB\Models\ApiLog\Types\Resavenue\ResavenueBookingPushDetails;
use App\DB\Models\ChannelLogs\embedded\ChannelLogAttempt;
use App\DB\Models\ChannelLogs\embedded\ChannelLogError;
use App\DB\Models\ChannelLogs\PushBookingLog\PushBookingLog;
use App\DB\Models\embedded\ApiLogReference;
use App\DB\Models\embedded\UserReference;
use App\DB\Models\PropertyChannelSettings\PropertyChannelSettings;
use App\DB\Models\PropertyChannelSettings\Resavenue\ResavenueDetails;
use App\Enums\ApiLogStatus;
use App\Enums\ChannelId;
use App\Enums\ChannelLogStatus;
use SYSOTEL\OTA\Common\Services\Resavenue\Api\ResavenueApi;
use SYSOTEL\OTA\Common\Services\Resavenue\ResavenueBookingResponseCreator;
use SYSOTEL\OTA\Common\Services\Resavenue\ResavenueHelpers;
use App\Services\ChannelServices\Contracts\BookingConfirmationPusherContract;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Exception;
use SYSOTEL\APP\BE\Common\Mongo\Documents\Booking\Booking;
use Throwable;

class ResavenueBookingPusher implements BookingConfirmationPusherContract
{
    protected ?UserReference $causer = null;
    protected PushBookingLog $log;
    protected PropertyChannelSettings $channelSettings;
    protected Booking $booking;

    /**
     * @param PushBookingLog $log
     * @param UserReference|null $causer
     * @throws LockException
     * @throws MappingException
     */
    public function __construct(PushBookingLog $log, UserReference $causer = null)
    {
        $this->causer = $causer;
        $this->log = $log;
        $channelSettings = PropertyChannelSettings::repository()->findById($log->channelSettingsId);
        if (!$channelSettings) {
            throw new Exception('Channel settings not found');
        }

        if (!$channelSettings->details instanceof ResavenueDetails) {
            throw new Exception('ResavenueSettings expected. Received something else');
        }

        $booking = Booking::repository()->find($log->booking?->_id);
        if (!$booking) {
            throw new Exception('Booking not found');
        }


        $this->booking = $booking;
        $this->channelSettings = $channelSettings;
    }

    /**
     * @return PushBookingLog
     */
    public function getLog(): PushBookingLog
    {
        return $this->log;
    }

    /**
     * @return PropertyChannelSettings|null
     */
    public function getChannelSettings(): PropertyChannelSettings|null
    {
        return $this->channelSettings;
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

    public function send(): PushBookingLog
    {
        $channelAttemptDetails = new ChannelLogAttempt;
        $channelAttemptDetails->markAsStarted();
        $this->log->attemptDetails()->associate($channelAttemptDetails);
        $this->log->status = ChannelLogStatus::PROCESSING;

        $channelDetails = new ResavenueBookingPushDetails;
        $channelDetails->internalBookingId = $this->log->booking?->_id;
        $channelDetails->status = $this->log->booking?->status?->value;
        $this->log->channelDetails()->associate($channelDetails);

        if($this->causer) {
            $this->log->causer()->associate(
                $this->causer->replicate()
            );
        }

        try {
            $booking = $this->getBooking();

            $request['OTA_HotelResNotifRQ'] = [
                'Target' => ResavenueHelpers::getTargetValue(),
                'Version' => '1.0',
                'EchoToken' => $this->log->id,
                'Timestamp' => now()->toDateTimeString(),
                'HotelReservations' => [ResavenueBookingResponseCreator::prepare($booking)->create()]
            ];

            $bookingPushRequest = json_encode($request);

            $api = new ResavenueApi();
            $apiLog = $api->pushBooking($bookingPushRequest);

            $this->log->apiLogRefs()->associate(
                ApiLogReference::createFromApiLog($apiLog)
            );

            $this->log->status = $apiLog->status != ApiLogStatus::SUCCESS
                ? ChannelLogStatus::FAILED
                : ChannelLogStatus::SUCCESS;

            $this->log->save();
        }catch (Throwable $throwable) {
            $this->log->status = ChannelLogStatus::FAILED;
            $this->log->error()->associate(
                ChannelLogError::createFromThrowable($throwable)
            );
        }

        $channelAttemptDetails = $this->log->attemptDetails;
        $channelAttemptDetails->markAsCompleted();
        $this->log->attemptDetails()->associate($channelAttemptDetails);
        $this->log->save();

        return $this->log;
    }
}
