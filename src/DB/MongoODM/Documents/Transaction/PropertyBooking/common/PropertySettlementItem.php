<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Transaction\PropertyBooking\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class PropertySettlementItem extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $type;

    /**
     * @var
     * @ODM\EmbedOne(
     *   discriminatorField="type",
     *   discriminatorMap={
     *     "PAYMENT_TRANSACTION"=PropertySettlementItemPaymentTransactionDetails::class,
     *     "OTHER_SETTLEMENT_ADJUSTMENT"=PropertySettlementItemPaymentTransactionDetails::class
     *   }
     * )
     */
    public $details;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
