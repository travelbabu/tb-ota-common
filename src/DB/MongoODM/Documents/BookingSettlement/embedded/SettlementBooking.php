<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\BookingSettlement\embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class SettlementBooking extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $_id;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
