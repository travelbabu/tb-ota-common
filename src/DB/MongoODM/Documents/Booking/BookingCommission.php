<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class BookingCommission extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="object_id")
     */
    public $contractId;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $value;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $percentage;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->value = 0;
        $this->percentage = 0;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'contractId' => $this->contractId,
            'value' => $this->value,
            'percentage' => $this->percentage,
        ];
    }
}
