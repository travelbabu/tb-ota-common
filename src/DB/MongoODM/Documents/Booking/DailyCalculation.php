<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccountSettings\AgentAccountSettings;

/**
 * @ODM\EmbeddedDocument
 */
class DailyCalculation extends EmbeddedDocument
{
    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $date;

    /**
     * @var ArrayCollection & SpaceRateItem[]
     * @ODM\EmbedMany (targetDocument=BookingRateItem::class)
     */
    public $appliedRates;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $baseCharges = 0; // auto calculated

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $extraAdultCharges = 0; // auto calculated

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $extraChildCharges = 0; // auto calculated

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $extraGuestCharges = 0; // auto calculated

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $spaceCharges = 0; // auto calculated

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $propertyDiscount = 0;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $propertyDiscountAppliedOn;

    /**
     * @var ArrayCollection & PropertyDiscountItem[]
     * @ODM\EmbedMany(targetDocument=BookingDiscountItem::class)
     */
    public $propertyDiscountItems;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $spaceSellPrice = 0; // auto calculated

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $propertyTax = 0;

    /**
     * @var ArrayCollection & TaxItem[]
     * @ODM\EmbedMany(targetDocument=TaxItem::class)
     */
    public $propertyTaxItems;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $spaceGrossCharges = 0; // auto calculated

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaCommission = 0;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaCommissionPercentage = 0;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $otaCommissionAppliedOn;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $otaCommissionTax = 0;

    /**
     * @var ArrayCollection & TaxItem[]
     * @ODM\EmbedMany(targetDocument=TaxItem::class)
     */
    public $otaCommissionTaxItems;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $finalOtaCommission = 0;

    /**
     * @var AffiliateCommission
     * @ODM\EmbedOne(targetDocument=AffiliateCommission::class)
     */
    public $affiliateCommission;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $spaceNetCharges = 0; // auto calculated

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->appliedRates = new ArrayCollection;
        $this->propertyTaxItems = new ArrayCollection();
        $this->otaCommissionTaxItems = new ArrayCollection;

        parent::__construct($attributes);
    }

    public function addRateItem(SpaceRateItem $item): static
    {
        $this->appliedRates->add($item);
        return $this;
    }

    /**
     * Document should have rates, discount, tax, commission
     */
    public function calculate(int $commissionPerc = 0): static
    {
        // tax and commission should be calculated // done, testing
        $this->baseCharges = 0;
        $baseRates = collect($this->appliedRates)->where('type', SpaceRateItem::TYPE_BASE_CHARGES);
        foreach ($baseRates as $appliedRate) {
            if ($appliedRate->type = SpaceRateItem::TYPE_BASE_CHARGES) {
                $this->baseCharges += $appliedRate->charges;
            }
        }
        $this->baseCharges = round($this->baseCharges, 2);

        $this->extraAdultCharges = 0;
        $extraAdultRates = collect($this->appliedRates)->where('type', SpaceRateItem::TYPE_EXTRA_ADULT_CHARGES);
        foreach ($extraAdultRates as $appliedRate) {
            if ($appliedRate->type = SpaceRateItem::TYPE_EXTRA_ADULT_CHARGES) {
                $this->extraAdultCharges += $appliedRate->charges;
            }
        }
        $this->extraAdultCharges = round($this->extraAdultCharges, Bill::DEFAULT_PRECISION);

        $this->extraChildCharges = 0;
        $extraChildRates = collect($this->appliedRates)->where('type', SpaceRateItem::TYPE_EXTRA_CHILD_CHARGES);
        foreach ($extraChildRates as $appliedRate) {
            if ($appliedRate->type = SpaceRateItem::TYPE_EXTRA_CHILD_CHARGES) {
                $this->extraChildCharges += $appliedRate->charges;
            }
        }
        $this->extraChildCharges = round($this->extraChildCharges, 2);

        $this->extraGuestCharges = round($this->extraAdultCharges + $this->extraChildCharges, Bill::DEFAULT_PRECISION);
        $this->spaceCharges = round($this->baseCharges + $this->extraGuestCharges, Bill::DEFAULT_PRECISION);
        $this->spaceSellPrice = round($this->spaceCharges - $this->propertyDiscount, Bill::DEFAULT_PRECISION);
        $this->spaceGrossCharges = round($this->spaceSellPrice + $this->propertyTax, Bill::DEFAULT_PRECISION);

        $this->spaceNetCharges = round($this->spaceGrossCharges - $this->otaCommission, Bill::DEFAULT_PRECISION);


        if($commissionPerc > 0) {
            $this->otaCommissionTaxItems->add(new TaxItem([
                'type' => TaxItem::TYPE_GST,
                'percentage' => $commissionPerc,
                'amount' => $this->otaCommission,
            ]));
        }

        return $this;
    }

    /**
     * @param int|null $perc
     */
    public function calculateGST(int $perc = null): static
    {
        $totalAmount = 0;

        foreach ($this->appliedRates as $rate) {
            $totalAmount += $rate->charges;
        }

        if (!$perc) {
            if ($totalAmount <= 7999) $perc = 12;
            else $perc = 18;
        }

        $this->propertyTax = (float)bcdiv(bcmul($totalAmount, $perc), 100, Bill::DEFAULT_PRECISION);
        $this->propertyTaxItems = new ArrayCollection;
        $this->propertyTaxItems->add(new TaxItem([
            'type' => TaxItem::TYPE_GST,
            'amount' => $this->propertyTax,
            'percentage' => $perc
        ]));

        return $this;
    }

    /**
     * @param TaxDetails $taxDetails
     * @param array $taxItems
     * @return $this
     */
    public function setTax(TaxDetails $taxDetails, array $taxItems): static
    {
        $this->propertyTax = $taxDetails;
        $this->propertyTaxItems = new ArrayCollection($taxItems);
        return $this;
    }

    /**
     * @param int $perc
     * @return $this
     */
    public function calculateCommission(int $perc): static
    {
        $this->otaCommission = 0;
        $this->otaCommissionTax = 0;
        $this->otaCommissionTaxItems = new ArrayCollection;
        $this->otaCommissionPercentage = $perc;

        $this->otaCommission = (float)bcdiv(bcmul($this->spaceSellPrice, $perc), 100, Bill::DEFAULT_PRECISION);
        $this->otaCommissionTax = (float) bcdiv(bcmul($this->otaCommission, 18), 100, Bill::DEFAULT_PRECISION);
        if($this->otaCommissionTax && $this->otaCommissionTax > 0) {
            $this->otaCommissionTaxItems->add(new TaxItem([
                'type' => TaxItem::TYPE_GST,
                'amount' =>  $this->otaCommissionTax,
                'percentage' => 18
            ]));
        }
        $this->finalOtaCommission = round($this->otaCommission + $this->otaCommissionTax, Bill::DEFAULT_PRECISION);
        $this->spaceNetCharges = round($this->spaceGrossCharges - $this->finalOtaCommission, Bill::DEFAULT_PRECISION);

        return $this;
    }

    /**
     * @param AgentAccountSettings $accountSettings
     * @return $this
     */
    public function calculateAffiliateCommission(AgentAccountSettings $accountSettings): static
    {
        $perc = $accountSettings->commission->value;

        if(!is_numeric($perc) || $perc < 0 || $perc > 100) {
            abort(500, 'Invalid percentage value ' . $perc . ' received for accountSettings id ' . $accountSettings->id);
        }

        $this->affiliateCommission = (new AffiliateCommission([
            'agentAccountSettingsID' => $accountSettings->id,
            'commission' => (float)bcdiv(bcmul($this->spaceSellPrice, $perc), 100, Bill::DEFAULT_PRECISION),
            'commissionPercentage' => $perc,
        ]))->setTds();

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
