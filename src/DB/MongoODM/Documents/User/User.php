<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\User;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Email;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Password;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PersonName;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\UserRepository;
use SYSOTEL\OTA\Common\Helpers\Parsers\UserParser;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="users",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\UserRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({
 *     "EXTRANET_USER":SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\ExtranetUser\ExtranetUser::class,
 *     "ADMIN"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Admin\Admin::class,
 *     "GUEST"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Guest\Guest::class,
 *     "AGENT"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Agent\Agent::class,
 *     "CORPORATE_USER"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\CorporateUser\CorporateUser::class,
 * })
 */
abstract class User extends Document implements AuthenticatableContract
{
    use AuthenticableTrait,
        Notifiable,
        HasPassword,
        CanResolveIntegerID,
        HasTimestamps,
        HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'users';

    /**
     * @inheritdoc
     */
    protected string $keyType = 'int';

    /**
     * @var int
     * @ODM\Id(strategy="CUSTOM", type="int", options={"class"=SYSOTEL\OTA\Common\DB\MongoODM\StorageStrategies\AutoIncrementID::class }))
     */
    public $id;

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
     * @var string
     * @ODM\Field(type="string")
     */
    public $gender;
    public const GENDER_MALE = 'M';
    public const GENDER_FEMALE = 'F';
    public const GENDER_OTHER = 'OTHER';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_BLOCKED = 'BLOCKED';

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $birthdate;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isMarried;

    /**
     * @var string
     */
    public $type;
    public const TYPE_EXTRANET_USER = 'EXTRANET_USER';
    public const TYPE_ADMIN = 'ADMIN';
    public const TYPE_GUEST = 'GUEST';
    public const TYPE_AGENT = 'AGENT';
    public const TYPE_CORPORATE_USER = 'CORPORATE_USER';

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
     * @var Password
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Password::class)
     */
    public $password;

    /**
     * @var UserReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $creator;

    protected $defaults = [
        'status' => self::STATUS_ACTIVE
    ];

    public function __construct(array $attributes = [])
    {
        $this->properties = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * Returns the parser
     *
     * @return UserParser
     */
    public function parser(): UserParser
    {
        return new UserParser($this);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return UserReference
     */
    public function prepareReferenceDocument(): UserReference
    {
        return UserReference::createFromUser($this);
    }

    /**
     * @return bool
     */
    public function isGuest(): bool
    {
        return $this->type === self::TYPE_GUEST;
    }

    /**
     * @return bool
     */
    public function isAgent(): bool
    {
        return $this->type === self::TYPE_AGENT;
    }

    /**
     * @return bool
     */
    public function isCorporateUser(): bool
    {
        return $this->type === self::TYPE_CORPORATE_USER;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->type === self::TYPE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isExtranetUser(): bool
    {
        return $this->type === self::TYPE_EXTRANET_USER;
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'id'             => $this->id,
            'name'           => toArrayOrNull($this->name),
            'designation'    => $this->designation,
            'type'           => $this->type,
            'status'         => $this->status,
            'email'          => toArrayOrNull($this->email),
            'mobile'         => toArrayOrNull($this->mobile),
            'creator'         => toArrayOrNull($this->creator),
            'createdAt'      => $this->createdAt,
            'updatedAt'      => $this->updatedAt,
        ]);
    }

    /**
     * @return bool
     */
    public function isEmailVerified(): bool
    {
        return isset($this->email) && $this->email->isVerified();
    }

    /**
     * User Repository
     *
     * @return UserRepository
     */
    public static function repository(): UserRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
