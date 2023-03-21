<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Email;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CorporateAccountRepository;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="corporateAccounts",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CorporateAccountRepository::class
 * ),
 * @ODM\HasLifecycleCallbacks
 */
class CorporateAccount extends Document
{
    use HasTimestamps, CanResolveIntegerID, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'corporateAccounts';

    /**
     * @var int
     * @ODM\Id(strategy="CUSTOM", type="int", options={"class"=SYSOTEL\OTA\Common\DB\MongoODM\StorageStrategies\AutoIncrementID::class }))
     */
    public $id;
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $companyName;

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
     * @var int
     * @ODM\Field(type="int")
     */
    public $primaryBranchID;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $createdBy;

    /**
     * @var ArrayCollection & CorporateUserDetails[]
     * @ODM\EmbedMany  (targetDocument=CorporateUserDetails::class)
     */
    public $users;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_VERIFICATION_PENDING = 'VERIFICATION_PENDING';
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';


    /**
     * @var UserReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $verifiedBy;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    protected $defaults = [
        'status' => self::STATUS_VERIFICATION_PENDING,
    ];

    public function __construct(array $attributes = [])
    {
        $this->users = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @return bool
     */
    public function hasVerifiedCompanyAddress(): bool
    {
        return isset($this->company->address);
    }

    /**
     * @return CorporateUserDetails|null
     */
    public function getAdminUser(): ?CorporateUserDetails
    {
        return collect($this->users)->firstWhere('role', CorporateUserDetails::ROLE_ADMIN);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'company' => toArrayOrNull($this->company),
            'users' => collect($this->users)->toArray(),
            'status' => $this->status,
        ]);
    }

    /**
     * @return CorporateAccountRepository
     */
    public static function repository(): CorporateAccountRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
