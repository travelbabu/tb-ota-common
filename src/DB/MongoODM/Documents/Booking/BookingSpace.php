<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class BookingSpace extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $spaceNo;

    /**
     * @var GuestCount
     * @ODM\EmbedOne(targetDocument=GuestCount::class)
     */
    public $guestCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $spaceID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $spaceName;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $productID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $productName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $mealPlanCode;

    /**
     * @var string[]
     * @ODM\Field(type="collection")
     */
    public $inclusions;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentMode;

    /**
     * @var PartialPayment
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment::class)
     */
    public $partialPayment;

    /**
     * @var array
     * @ODM\Field (type="collection")
     */
    public $guestIDs;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'spaceNo' => $this->spaceNo,
            'spaceID' => $this->spaceID,
            'spaceName' => $this->spaceName,
            'productID' => $this->productID,
            'productName' => $this->productName,
            'guestCount' => toArrayOrNull($this->guestCount),
            'paymentMode' => $this->paymentMode,
            'partialPayment' => toArrayOrNull($this->partialPayment),
            'guestIDs' => $this->guestIDs,
        ];
    }
}
