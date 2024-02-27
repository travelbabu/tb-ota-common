<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;

/**
 * @ODM\EmbeddedDocument
 */
class BookingPolicy extends EmbeddedDocument
{
    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $cancellationPolicyID;

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $generalPolicyID;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $cancellationPolicyText;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $generalPolicyText;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $freeCancellationAvailable;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $freeCancellationDescription;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $nonRefundable;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $nonRefundableDescription;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'cancellationPolicyID' => $this->cancellationPolicyID,
            'generalPolicyID' => $this->generalPolicyID,
            'cancellationPolicyText' => $this->cancellationPolicyText,
            'generalPolicyText' => $this->generalPolicyText,
            'freeCancellationAvailable' => $this->freeCancellationAvailable,
            'freeCancellationDescription' => $this->freeCancellationDescription,
            'nonRefundable' => $this->nonRefundable,
            'nonRefundableDescription' => $this->nonRefundableDescription,
        ];
    }
}
