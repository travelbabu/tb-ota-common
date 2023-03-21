<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class BookingVoucherItem extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $for;
    public const FOR_GUEST = 'GUEST';
    public const FOR_PROPERTY = 'PROPERTY';
    public const FOR_AGENT = 'AGENT';


    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_CONFIRMATION = 'CONFIRMATION';
    public const TYPE_CANCELLATION = 'CANCELLATION';


    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $filePath;


    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $timestamp;

    /**
     * @ODM\PrePersist
     */
    public function markCreatedAtTimestamp()
    {
        if(!isset($this->timestamp)){
            $this->timestamp = now();
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'for' => $this->value,
            'status' => $this->percentage,
            'filePath' => $this->percentage,
            'timestamp' => $this->timestamp,
        ];
    }
}
