<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;

/**
 * @ODM\EmbeddedDocument
 */
class BookingCheckInDetails extends EmbeddedDocument
{
    /**
     * @var ?boolean
     * @ODM\Field(type="bool")
     */
    public $checkInMarked;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkInMarkedAt;

    /**
     * @var ?UserReference
     * @ODM\EmbedOne (targetDocument=)
     */
    public $checkInMarkedBy;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
