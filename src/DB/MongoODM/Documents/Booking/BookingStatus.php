<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class BookingStatus extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $value;
    public const STATUS_ATTEMPT = 'ATTEMPT';
    public const STATUS_EXPIRED = 'EXPIRED';
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_CONFIRMED = 'CONFIRMED';
    public const STATUS_CANCELLED = 'CANCELLED';
    public const STATUS_MODIFIED = 'MODIFIED';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $failureType;
    public const FAILURE_TYPE_PAYMENT_FAILURE = 'PAYMENT_FAILURE';
    public const FAILURE_TYPE_INTERNAL_ERROR = 'INTERNAL_ERROR';
    public const FAILURE_TYPE_VENDOR_ERROR = 'VENDOR_ERROR';

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
            'value' => $this->value,
            'remark' => $this->remark,
        ];
    }
}
