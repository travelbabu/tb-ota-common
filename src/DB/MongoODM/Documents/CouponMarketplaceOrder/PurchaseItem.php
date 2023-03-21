<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CouponMarketplaceOrder;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PurchaseItem extends EmbeddedDocument
{
    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $marketplaceCouponID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $code;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $qty;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $purchaseValuePerItem;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $totalPurchaseValue;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'marketplaceCouponID' => $this->marketplaceCouponID,
            'code' => $this->code,
            'qty' => $this->qty,
            'purchaseValuePerItem' => $this->purchaseValuePerItem,
            'totalPurchaseValue' => $this->totalPurchaseValue,
        ]);
    }
}
