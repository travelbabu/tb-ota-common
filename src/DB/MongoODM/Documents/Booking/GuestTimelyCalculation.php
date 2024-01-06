<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class GuestTimelyCalculation extends EmbeddedDocument
{
    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $startTime;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $endTime;

    /**
     * @var ?GuestSpaceCharges
     * @ODM\EmbedOne (targetDocument=GuestSpaceCharges::class)
     */
    public $spaceCharges;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->spaceCharges = new ServiceCharges;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'spaceCharges' => toArrayOrNull($this->spaceCharges),
        ];
    }
}
