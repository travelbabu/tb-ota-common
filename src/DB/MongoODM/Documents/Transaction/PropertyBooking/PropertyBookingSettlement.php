<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Transaction\PropertyBooking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Transaction\Settlement;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Transaction\common\SettlementBooking;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Transaction\common\SettlementProperty;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Transaction\PropertyBooking\common\PropertySettlementCalculations;

/**
 * @ODM\Document
 */
class PropertyBookingSettlement extends Settlement
{
    /**
     * @var ?SettlementBooking
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Transaction\common\SettlementBooking::class)
     */
    public $booking;

    /**
     * @var ?PropertySettlementCalculations
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Transaction\PropertyBooking\common\PropertySettlementCalculations::class)
     */
    public $calculations;

    /**
     * @var ?SettlementProperty
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Transaction\common\SettlementProperty::class)
     */
    public $property;
}