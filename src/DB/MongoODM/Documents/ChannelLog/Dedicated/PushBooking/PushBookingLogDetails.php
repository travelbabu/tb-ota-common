<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\PushBooking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class PushBookingLogDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $bookingID;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $bookingStatus;

    public function toArray(): array
    {
        return [];
    }
}
