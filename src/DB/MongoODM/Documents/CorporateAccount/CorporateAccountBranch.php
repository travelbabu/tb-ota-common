<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Carbon;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Address;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Email;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CorporateAccountBranchRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="corporateAccountBranches",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CorporateAccountBranchRepository::class
 * ),
 * @ODM\HasLifecycleCallbacks
 */
class CorporateAccountBranch extends Document

{
    use CanResolveIntegerID, HasDefaultAttributes, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'corporateAccountBranches';

    /**
     * @var int
     * @ODM\Id(strategy="CUSTOM", type="int", options={"class"=SYSOTEL\OTA\Common\DB\MongoODM\StorageStrategies\AutoIncrementID::class }))
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $accountID;

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
     * @var Mobile
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile::class)
     */
    public $mobile;

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
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_VERIFICATION_PENDING = 'VERIFICATION_PENDING';
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';

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
        'status' => self::STATUS_VERIFICATION_PENDING,
    ];

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }

    public static function repository(): CorporateAccountBranchRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
