<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\FileV2;
use SYSOTEL\OTA\Common\Helpers\Enums;

/**
 * @ODM\MappedSuperclass
 */
abstract class BookingPayment extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $_id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $no;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentGroup;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentMethod;
    // todo paymentGroupDetails

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amountToBePaid;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amountPaid;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $acknowledgeAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $paymentReceivedAt;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $remark;

    /**
     * @var ArrayCollection<FileV2>
     * @ODM\EmbedMany(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\FileV2::class)
     */
    public $attachments;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->attachments = new ArrayCollection;

        parent::__construct($attributes);
    }

    public function markAsAcknowledge(string $status = Enums::BOOKING_PAYMENT_TRANSACTION_STATUS_PAID): static
    {
        $this->acknowledgeAt = now();
        $this->status = $status;
        return $this;
    }

    public abstract function getType(): string;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->_id,
            'no' => $this->no,
            'type' => $this->type,
            'amountToBePaid' => $this->amountToBePaid,
            'amountPaid' => $this->amountPaid,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'acknowledgeAt' => $this->acknowledgeAt,
            'remark' => $this->remark,
        ];
    }
}
