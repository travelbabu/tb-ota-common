<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common\transactionTypes;

use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class

SettlementTransactionTypeSettlementAdjustment extends SettlementTransaction
{
    /**
     * @var ?string
     * @ODM\Field(type="object_id")
     */
    public $settlementID;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
