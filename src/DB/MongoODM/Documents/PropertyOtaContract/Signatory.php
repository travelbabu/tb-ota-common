<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyOtaContract;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class Signatory extends EmbeddedDocument
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
    public $designation;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $email;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $mobile;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $verificationToken;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $causer;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $approvedAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;

    public function markAsApproved(): static
    {
        $this->approvedAt = now();
        return $this;
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'name' => $this->name,
            'designation' => $this->designation,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'verificationToken' => $this->verificationToken,
            'createdAt' => $this->createdAt,
            'causer' => toArrayOrNull($this->causer),
        ]);
    }
}
