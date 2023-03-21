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
class BookingAgentDetails extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

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
     * @var int
     * @ODM\Field(type="int")
     */
    public $accountID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $companyName;

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $agentAccountSettingsID;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [

        ];
    }
}
