<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\VerificationTokenRepository;

/**
 * @ODM\Document(
 *     collection="verificationTokens",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\VerificationTokenRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class VerificationToken extends Document
{
    use HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'verificationTokens';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TOKEN_MOBILE_VERIFICATION = 'MOBILE_VERIFICATION';
    public const TOKEN_EMAIL_VERIFICATION = 'EMAIL_VERIFICATION';
    public const TOKEN_MOBILE_LOGIN = 'MOBILE_LOGIN';
    public const TOKEN_EMAIL_LOGIN = 'EMAIL_LOGIN';

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $userID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $target;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $token;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_EXPIRED = 'EXPIRED';

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $usedAt;

    protected $defaults = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * @return $this
     */
    public function markAsUsedAt(): self
    {
        $this->usedAt = now();
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
    }

    /**
     * @return $this
     */
    public function markAsExpired(): static
    {
        $this->status = self::STATUS_EXPIRED;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'           => $this->id,
            'type'         => $this->type,
            'userID'       => $this->userID,
            'target'       => $this->target,
            'token'        => $this->token,
            'status'       => $this->status,
            'createdAt'    => $this->createdAt,
            'updatedAt'    => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return VerificationTokenRepository
     */
    public static function repository(): VerificationTokenRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
