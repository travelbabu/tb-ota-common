<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common\transactionTypes;

use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class SettlementTransaction extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $type;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $amount;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
