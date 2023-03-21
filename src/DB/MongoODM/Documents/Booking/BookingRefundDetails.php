<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class BookingRefundDetails extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_INITIATE = 'PENDING';
    public const STATUS_CONFIRMED = 'COMPLETED';

    /**
     * @var double
     * @ODM\Field(type="double")
     */
    public $amountToBeRefunded;

    /**
     * @var double
     * @ODM\Field(type="double")
     */
    public $amountRefunded;

    /**
     * @var ArrayCollection & BookingRefund[]
     * @ODM\EmbedMany (targetDocument=BookingRefund::class)
     */
    public $refunds;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->refunds = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'amountToBeRefunded' => $this->amountToBeRefunded,
            'amountRefunded' => $this->amountRefunded,
            'refunds' => collect($this->refunds)->toArray(),
        ];
    }

    /**
     * @param BookingRefund $refund
     * @return $this
     */
    public function addRefund(BookingRefund $refund): static
    {
        $this->refunds->add($refund);
        return $this;
    }

    public function getRefundByID(string $id): ?BookingRefund
    {
        return collect($this->refunds)->firstWhere('id', $id);
    }

    public function calculate()
    {
        //
    }
}
