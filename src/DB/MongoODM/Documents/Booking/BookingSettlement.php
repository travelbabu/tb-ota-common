<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Email;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\FileV2;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile;

/**
 * @ODM\EmbeddedDocument
 */
class BookingSettlement extends EmbeddedDocument
{
    /**
     * @var ArrayCollection<FileV2>
     * @ODM\EmbedMany(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\FileV2::class)
     */
    public $attachments;

    public function toArray(): array
    {
        return [

        ];
    }
}
