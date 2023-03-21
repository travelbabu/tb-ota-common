<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySearchRecord\SpaceConfigItem;

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
     * @var int
     * @ODM\Field(type="int")
     */
    public $totalCount;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'adultCount' => $this->adultCount,
            'childCount' => $this->childCount,
            'totalCount' => $this->totalCount,
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
