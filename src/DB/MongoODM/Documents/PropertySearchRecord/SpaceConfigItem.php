<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySearchRecord;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class SpaceConfigItem extends EmbeddedDocument
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
     * @var array
     * @ODM\Field(type="collection")
     */
    public $childAges;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $guestCount;

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
    public function guestCountString(): string
    {
        $guestCount = $this->guestCount;
        if(!$guestCount || $guestCount < 1) {
            return '';
        }

        return $guestCount == 1 ? "1 Guest" : "$guestCount Guests";
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'adultCount'  => $this->adultCount,
            'childCount'  => $this->childCount,
            'childAges'   => $this->childAges,
            'guestCount'  => $this->guestCount,
        ]);
    }
}
