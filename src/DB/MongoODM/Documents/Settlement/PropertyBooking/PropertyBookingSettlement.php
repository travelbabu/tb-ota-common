<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\PropertyBooking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common\SettlementBooking;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common\SettlementProperty;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\Settlement;

/**
 * @ODM\Document
 */
class PropertyBookingSettlement extends Settlement
{
    /**
     * @var ?SettlementBooking
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common\SettlementBooking::class)
     */
    public $booking;

    /**
     * @var ?SettlementProperty
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common\SettlementProperty::class)
     */
    public $property;
}