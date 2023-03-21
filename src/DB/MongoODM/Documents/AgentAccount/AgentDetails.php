<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Carbon;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class AgentDetails extends EmbeddedDocument

{
    use HasDefaultAttributes, HasTimestamps;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $role;
    public const ROLE_ADMIN = "ADMIN";
    public const ROLE_USER = "USER";

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_BLOCKED = 'BLOCKED';

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $createdBy;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;


    protected $defaults = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'role' => $this->role,
            'status' => $this->status,
            'createdBy' => toArrayOrNull($this->createdBy),
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);
    }
}
