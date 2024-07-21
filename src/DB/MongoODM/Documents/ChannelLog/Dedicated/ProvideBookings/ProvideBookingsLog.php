<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\ProvideBookings;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\ChannelLog;
use SYSOTEL\OTA\Common\Helpers\Enums;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class ProvideBookingsLog extends ChannelLog
{
    /**
     * @var ProvideBookingsLogDetails
     * @ODM\EmbedOne(targetDocument=ProvideBookingsLogDetails::class)
     */
    public $details;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter(
            array_merge(parent::toArray(), [

            ])
        );
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return Enums::API_LOG_RESAVENUE_PROVIDE_BOOKINGS;
    }
}
