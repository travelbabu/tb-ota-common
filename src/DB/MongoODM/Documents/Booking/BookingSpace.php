<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @var GuestCount
     * @ODM\EmbedOne(targetDocument=GuestCount::class)
     */
    public $guestCount;

    /**
     * @var ArrayCollection & GuestCount[]
     * @ODM\EmbedMany(targetDocument=GuestCount::class)
     */
    public $guestCounts;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $spaceID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierSpaceID;

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
    public $supplierProductID;

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
     * @var int
     * @ODM\Field(type="int")
     */
    public $noOfUnits;

    /**
     * @var array
     * @ODM\Field (type="collection")
     */
    public $guestIDs;

    /**
     * @var ArrayCollection & DailyCalculation[]
     * @ODM\EmbedMany(targetDocument=DailyCalculation::class)
     */
    public $dailyCalculations;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->dailyCalculations = new ArrayCollection;
        $this->guestCounts = new ArrayCollection;

        parent::__construct($attributes);
    }

    public function addDailyCalculation(DailyCalculation $item): static
    {
        $this->dailyCalculations->add($item);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'spaceID'           => $this->spaceID,
            'supplierSpaceID'           => $this->supplierSpaceID,
            'spaceName'         => $this->spaceName,
            'productID'         => $this->productID,
            'supplierProductID'         => $this->supplierProductID,
            'productName'       => $this->productName,
            'guestCount'        => toArrayOrNull($this->guestCount),
            'guestCounts'        => collect($this->guestCounts)->toArray(),
            'paymentMode'       => $this->paymentMode,
            'partialPayment'    => toArrayOrNull($this->partialPayment),
            'guestIDs'          => $this->guestIDs,
            'dailyCalculations' => collect($this->dailyCalculations)->toArray(),
            'charges'           => $this->charges,
            'tax'               => toArrayOrNull($this->tax),
        ];
    }
}
