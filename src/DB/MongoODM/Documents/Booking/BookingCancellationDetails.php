<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class BookingCancellationDetails extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_INITIATED = 'INITIATED';
    public const STATUS_PROCESSING = 'PROCESSING';
    public const STATUS_PROCESSED = 'PROCESSED';

    /**
     * @var UserReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $initiator;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $initiatedAt;

    /**
     * @var UserReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $verifier;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $verifiedAt;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $refundAmount;

    /**
     * @var UserReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $acknowledgeBy;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $acknowledgeAt;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $remark;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'remark' => $this->remark,
            'status' => $this->status,
            'initiator' => toArrayOrNull($this->initiator),
            'initiatedAt' => $this->initiatedAt,
            'verifier' => toArrayOrNull($this->verifier),
            'verifiedAt' => $this->verifiedAt,
            'acknowledgeBy' => toArrayOrNull($this->acknowledgeBy),
            'acknowledgeAt' => $this->acknowledgeAt,
        ];
    }
}
