<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;

/**
 * @ODM\EmbeddedDocument
 */
class BookingNoShowDetails extends EmbeddedDocument
{
    /**
     * @var ?boolean
     * @ODM\Field(type="bool")
     */
    public $noShowMarked;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $noShowMarkedAt;

    /**
     * @var ?UserReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $noShowMarkedBy;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
