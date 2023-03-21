<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class StayDates extends EmbeddedDocument
{
    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkInDate;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $checkOutDate;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $lengthOfStay;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'checkInDate'  => $this->checkInDate,
            'checkOutDate' => $this->checkOutDate,
            'lengthOfStay'  => $this->lengthOfStay,
        ];
    }

    /**
     * @return string
     */
    public function stayDateString(): string
    {
        $los = $this->lengthOfStay;

        if($los === 1) {
            return '1 night';
        } else {
            return "$los night ". $los + 1 ." days";
        }
    }

    /**
     * @return string
     */
    public function stayNightString(): string
    {
        $los = $this->lengthOfStay;

        if($los === 1) {
            return '1 night';
        } else {
            return "$los nights";
        }
    }

    /**
     * @return Carbon
     */
    public function getFirstBillingDate(): Carbon
    {
        return $this->checkInDate;
    }

    /**
     * @return Carbon
     */
    public function getLastBillingDate(): Carbon
    {
        return $this->checkOutDate->clone()->subDay();
    }
}
