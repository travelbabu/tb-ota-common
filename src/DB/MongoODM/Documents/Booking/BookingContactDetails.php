<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Email;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class BookingContactDetails extends EmbeddedDocument
{
    /**
     * @var Email
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Email::class)
     */
    public $email;

    /**
     * @var Mobile|null
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile::class)
     */
    public $mobile;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'email' => toArrayOrNull($this->email),
            'mobile' => toArrayOrNull($this->mobile),
        ];
    }
}
