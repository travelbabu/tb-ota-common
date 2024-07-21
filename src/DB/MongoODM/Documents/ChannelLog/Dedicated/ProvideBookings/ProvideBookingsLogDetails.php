<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\ProvideBookings;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class ProvideBookingsLogDetails extends EmbeddedDocument
{
    /**
     * @var ?Carbon
     * @ODM\field(type="carbon")
     */
    public $startDate;

    /**
     * @var ?Carbon
     * @ODM\field(type="carbon")
     */
    public $endDate;

    public function toArray(): array
    {
        return [];
    }
}
