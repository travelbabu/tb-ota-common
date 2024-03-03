<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class GuestCount extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $adultCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $childCount;

    /**
     * @var ?int[]
     * @ODM\Field(type="collection")
     */
    public $childAges;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $totalCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $consideredAdultCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $consideredChildCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $chargeableTotalCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $freeGuestCount = 0;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'adultCount' => $this->adultCount,
            'childCount' => $this->childCount,
            'childAges' => $this->childAges,
            'totalCount' => $this->totalCount,

            'consideredAdultCount' => $this->consideredAdultCount,
            'consideredChildCount' => $this->consideredChildCount,
            'chargeableTotalCount' => $this->chargeableTotalCount,

            'freeGuestCount' => $this->freeGuestCount,

            'adultChildCountString' => $this->adultChildCountString(),
            'adultCountString' => $this->adultCountString(),
            'childCountString' => $this->childCountString(),
            'guestCountString' => $this->guestCountString(),
        ];
    }

    /**
     * @return string
     */
    public function adultChildCountString(): string
    {
        $adultCount = $this->adultCount;
        $childCount = $this->childCount;

        if(!$adultCount || $adultCount < 1) {
            return '';
        }

        $string = $adultCount == 1 ? "1 Adult" : "$adultCount Adults";

        if(isset($childCount) && $childCount > 0) {
            $string .= $childCount == 1 ? " 1 Child" : " $childCount Children";
        }

        return $string;
    }

    /**
     * @return string
     */
    public function adultCountString(): string
    {
        $count = $this->adultCount;

        if(!$count || $count < 1) {
            return '';
        }

        return $count == 1 ? "1 Adult" : "$count Adults";
    }

    /**
     * @return string
     */
    public function childCountString(): string
    {
        $count = $this->childCount;

        if(!$count || $count < 1) {
            return '';
        }

        return $count == 1 ? "1 Child" : "$count Children";
    }

    /**
     * @return string
     */
    public function guestCountString(): string
    {
        $guestCount = $this->totalCount;
        if(!$guestCount || $guestCount < 1) {
            return '';
        }

        return $guestCount == 1 ? "1 Guest" : "$guestCount Guests";
    }
}
