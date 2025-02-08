<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\PropertyBooking\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class PropertySettlementItemPaymentTransactionDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="object_id")
     */
    public $transactionID;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
