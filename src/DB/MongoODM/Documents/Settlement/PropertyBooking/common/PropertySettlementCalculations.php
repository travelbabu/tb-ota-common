<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class PropertySettlementCalculations extends EmbeddedDocument
{
    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $bookingAmount;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $commission;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $commissionTax;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $commissionTaxPercentage;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $totalCommission;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $tds;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $tdsPercentage;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $tcs;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $tcsPercentage;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $otaToPropertyPayable;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $prepaidAmount;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $payAtPropertyAmount;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $ataToPropertySettlementAmount;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
