<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class BookingWebCheckInDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkedInAt;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $guestArrivalTime;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $guestFirstName;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $guestLastName;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $guestFullName;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $guestDob;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $guestPinCode;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $guestCityName;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
