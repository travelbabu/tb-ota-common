<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class CompanyDetails extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $rawAddress;

    /**
     * @var Address
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Address::class)
     */
    public $address;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $addressVerifiedBy;

    /**
     * @var Email
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Email::class)
     */
    public $email;

    /**
     * @var Mobile
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile::class)
     */
    public $mobile;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $websiteURL;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'name' => $this->name,
            'rawAddress' => toArrayOrNull($this->rawAddress),
            'address' => toArrayOrNull($this->address),
            'addressVerifiedBy' => toArrayOrNull($this->addressVerifiedBy),
            'email' => toArrayOrNull($this->email),
            'mobile' => toArrayOrNull($this->mobile),
            'websiteURL' => $this->websiteURL,
        ]);
    }
}
