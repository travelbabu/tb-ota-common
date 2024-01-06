<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Email;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile;

/**
 * @ODM\EmbeddedDocument
 */
class BookingChannel extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="object_id")
     */
    public $_id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $channelId;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->_id,
            'channelId' => $this->channelId,
        ];
    }
}
