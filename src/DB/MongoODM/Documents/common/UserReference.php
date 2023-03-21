<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class UserReference extends EmbeddedDocument
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
    public $type;

    /**
     * @var PersonName
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PersonName::class)
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $designation;

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
    public $ip;

    /**
     * @var string[]
     * @ODM\Field(type="collection")
     */
    public $ips;

    /**
     * @param User $user
     * @return UserReference
     */
    public static function createFromUser(User $user): UserReference
    {
        $userRef = new self([
            'id' => $user->id,
            'name' => $user->name,
            'designation' => $user->designation,
            'type' => $user->type,
            'ip' => request()->getClientIp(),
            'ips' => request()->getClientIps(),
        ]);

        if($user->email->id ?? false) {
            $userRef->email = new Email(['id' => $user->email->id]);
        }

        if($user->mobile->number ?? false) {
            $userRef->mobile = new Mobile(['number' => $user->mobile->number]);
        }

        return $userRef;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'type' => $this->type,
            'name' => toArrayOrNull($this->name),
            'email' => toArrayOrNull($this->email),
            'ip' => $this->ip,
        ]);
    }
}
