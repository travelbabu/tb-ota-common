<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\OtaPayment;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\BookingSettlement\embedded\SettlementBooking;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     collection="settlementPayments",
 * )
 * @ODM\HasLifecycleCallbacks
 */
class OtaPayment extends Document
{
    use HasRepository, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'settlementPayments';

    /**
     * @var ?string
     * @ODM\Id
     */
    public $id;

    /**
     * @var ?SettlementBooking
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\SettlementPayment\embedded\SettlementBooking::class)
     */
    public $booking;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $status;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
