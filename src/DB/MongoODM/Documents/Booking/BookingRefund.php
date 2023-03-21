<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class BookingRefund extends EmbeddedDocument
{
    use HasTimestamps;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_INITIATED = 'INITIATED';
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_CONFIRMED = 'CONFIRMED';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $reason;
    public const REASON_ADJUSTMENT = 'ADJUSTMENT';
    public const REASON_CANCELLATION = 'CANCELLATION';


    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $method;
    public const METHOD_CASHFREE_PG = 'CASHFREE_PG';
    public const METHOD_CASH = 'CASH';
    public const METHOD_BANK_TRANSFER = 'BANK_TRANSFER';
    public const METHOD_UNKNOWN = 'UNKNOWN';

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amount;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $remark;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $creator;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $verifier;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $verifiedAt;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'reason' => $this->reason,
            'method' => $this->method,
            'amount' => $this->amount,
            'remark' => $this->remark,
            'creator' => toArrayOrNull($this->creator),
            'verifier' => toArrayOrNull($this->verifier),
            'createdAt' => $this->createdAt,
            'verifiedAt' => $this->verifiedAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
