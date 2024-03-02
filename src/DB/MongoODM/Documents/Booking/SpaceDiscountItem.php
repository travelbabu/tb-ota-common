<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\isSignedNumber;

/**
 * @ODM\EmbeddedDocument
 */
class SpaceDiscountItem extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $appliedOn;

    /**
     * @var string
     * @ODM\Field(type="object_id")
     */
    public $promotionDocumentID;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $promotionID;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $type;

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
     * @var float
     * @ODM\Field(type="float")
     */
    public $percentage;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $description;

    /**
     * @param int|float $newAmount
     * @return static
     */
    public function addAmount(int|float $newAmount): static
    {
        if (!isSignedNumber($this->amount)) {
            return $this;
        }

        if (!isSignedNumber($newAmount)) {
            return $this;
        }

        $this->amount = round($this->amount + $newAmount, 2);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'promotionDocumentID' => $this->promotionDocumentID,
            'promotionID' => $this->promotionID,
            'type' => $this->type,
            'code' => $this->code,
            'name' => $this->name,
            'amount' => $this->amount,
            'description' => $this->description,
        ];
    }
}
