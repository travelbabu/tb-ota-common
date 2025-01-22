<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity\ActivityType;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class SettlementBooking extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $bookingID;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkIn;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkInDate;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkOut;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkOutDate;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAtDate;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $paymentMode;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $status;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $guestID;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $primaryGuestFullName;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return []
    }
}
