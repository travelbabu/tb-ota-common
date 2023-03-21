<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;

/**
 * @ODM\EmbeddedDocument
 */
class AffiliateCommission extends EmbeddedDocument
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $commission = 0;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $commissionPercentage = 0;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $commissionAppliedOn;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $tds = 0;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $tdsPercentage = 0;

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $agentAccountSettingsID;

    /**
     * @param int $perc
     * @return AffiliateCommission
     */
    public function setTds(int $perc = 5): static
    {
        $this->tdsPercentage = $perc;
        $this->tds = (float)bcdiv(bcmul($this->commission, $perc), 100, Bill::DEFAULT_PRECISION);
        return $this;
    }

    /**
     * @param AffiliateCommission $affiliateCommission
     * @return $this
     */
    public function addFromAffiliateCommission(AffiliateCommission $affiliateCommission): static
    {
        $this->agentAccountSettingsID = $affiliateCommission->agentAccountSettingsID;
        $this->commission += $affiliateCommission->commission;
        $this->commissionPercentage = $affiliateCommission->commissionPercentage;
        $this->tds = $affiliateCommission->tds;
        $this->tdsPercentage = $affiliateCommission->tdsPercentage;
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
