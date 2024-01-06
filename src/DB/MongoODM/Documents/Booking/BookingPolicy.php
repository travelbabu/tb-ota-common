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
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'cancellationPolicyID' => $this->cancellationPolicyID,
            'generalPolicyID' => $this->generalPolicyID,
            'cancellationPolicyText' => $this->cancellationPolicyText,
            'generalPolicyText' => $this->generalPolicyText,
        ];
    }
}
