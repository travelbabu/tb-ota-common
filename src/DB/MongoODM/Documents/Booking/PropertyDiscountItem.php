<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyDiscountItem extends EmbeddedDocument
{
    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $promotionID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $code;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amount;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $description;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'promotionID' => $this->promotionID,
            'code' => $this->code,
            'name' => $this->name,
            'amount' => $this->amount,
            'description' => $this->description,
        ];
    }
}
