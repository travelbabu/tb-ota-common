<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Transaction;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     collection="settlements",
 * )
 * @ODM\HasLifecycleCallbacks
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({
 *     "BOOKING_PROPERTY": SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\PropertyBooking\PropertyBookingSettlement::class,
 * })
 */
abstract class Transaction extends Document
{
    use HasRepository, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'settlements';

    /**
     * @var ?string
     * @ODM\Id
     */
    public $id;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $settlementAmount;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $settledOn;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
        ]);
    }
}
