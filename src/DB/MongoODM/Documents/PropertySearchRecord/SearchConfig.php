<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySearchRecord;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Location;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\dateArray;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class SearchConfig extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $sortBy;
    public const SORT_BY_POPULARITY = 'POPULARITY';
    public const SORT_BY_USER_RATING_HTL = 'USER_RATING_HTL';
    public const SORT_BY_STAR_RATING_LTH = 'STAR_RATING_LTH';
    public const SORT_BY_STAR_RATING_HTL = 'STAR_RATING_HTL';
    public const SORT_BY_PRICE_HTL = 'PRICE_HTL';
    public const SORT_BY_PRICE_LTH = 'PRICE_LTH';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $destinationID;

    /**
     * @var Location
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Location::class)
     */
    public $location;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $destinationType;
    const DESTINATION_TYPE_CITY = 'CITY';
    const DESTINATION_TYPE_AREA = 'AREA';
    const DESTINATION_TYPE_PROPERTY = 'PROPERTY';
    const DESTINATION_TYPE_COORDINATES = 'COORDINATES';

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
     * @var int
     * @ODM\Field(type="int")
     */
    public $totalSpaceCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $totalAdultCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $totalChildCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $totalGuestCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $maxGuestPerSpace;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $minGuestPerSpace;

    /**
     * @var ArrayCollection & SpaceConfigItem[]
     * @ODM\EmbedMany(targetDocument=SpaceConfigItem::class)
     */
    public $spaceConfigItems;

    /**
     * @var SearchFilters
     * @ODM\EmbedOne (targetDocument=SearchFilters::class)
     */
    public $filters;

    public function __construct(array $attributes = [])
    {
        $this->spaceConfigItems = new ArrayCollection();

        parent::__construct($attributes);
    }

    public function lastBillingDate(): Carbon
    {
        return $this->checkOutDate->clone()->subDay(1);
    }

    /**
     * @return Carbon[]
     */
    public function billingDates(): array
    {
        return dateArray($this->checkInDate, $this->checkOutDate->copy()->subDay());
    }

    /**
     * @ODM\PrePersist
     */
    public function prePersist(){
        $this->setCalculativeFields();
    }

    /**
     * @ODM\PreUpdate
     */
    public function preUpdate(){
        $this->setCalculativeFields();
    }

    protected function setCalculativeFields()
    {
        $this->checkInDate = $this->checkInDate->startOfDay();
        $this->checkOutDate = $this->checkOutDate->startOfDay();
        $this->lengthOfStay = $this->checkInDate->diffInDays($this->checkOutDate);
        $this->minGuestPerSpace = null;
        $this->maxGuestPerSpace = 0;
        $this->totalAdultCount = 0;
        $this->totalChildCount = 0;
        $this->totalGuestCount = 0;

        foreach($this->spaceConfigItems as $i => $item) {

            $this->spaceConfigItems[$i]->guestCount = $item->adultCount + $item->childCount;

            if($this->maxGuestPerSpace < $item->guestCount) {
                $this->maxGuestPerSpace = $item->guestCount;
            }

            if(!isset($this->minGuestPerSpace) || $this->minGuestPerSpace > $item->guestCount) {
                $this->minGuestPerSpace = $item->guestCount;
            }

            $this->totalSpaceCount++;
            $this->totalAdultCount += $item->adultCount;
            $this->totalChildCount += $item->childCount;
            $this->totalGuestCount += $item->guestCount;
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'destinationID'     => $this->destinationID,
            'destinationType'   => $this->destinationType,
            'checkInDate'       => $this->checkInDate,
            'checkOutDate'      => $this->checkOutDate,
            'lengthOfStay'      => $this->lengthOfStay,
            'totalSpaceCount'   => $this->totalSpaceCount,
            'totalAdultCount'   => $this->totalAdultCount,
            'totalChildCount'    => $this->totalChildCount,
            'maxGuestPerSpace'  => $this->maxGuestPerSpace,
            'minGuestPerSpace'  => $this->minGuestPerSpace,
            'spaceConfigItems'  => collect($this->spaceConfigItems)->toArray(),
            'filters'           => toArrayOrNull($this->filters),
        ]);
    }
}
