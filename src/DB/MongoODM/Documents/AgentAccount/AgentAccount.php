<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CompanyDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\TravelAgentAccountsRepository;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="agentAccounts",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\TravelAgentAccountsRepository::class
 * ),
 * @ODM\HasLifecycleCallbacks
 */
class AgentAccount extends Document
{
    use HasTimestamps, CanResolveIntegerID, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'agentAccounts';

    /**
     * @var int
     * @ODM\Id(strategy="CUSTOM", type="int", options={"class"=SYSOTEL\OTA\Common\DB\MongoODM\StorageStrategies\AutoIncrementID::class }))
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_COMPANY = 'COMPANY';
    public const TYPE_INDIVIDUAL = 'INDIVIDUAL';

    /**
     * @var CompanyDetails
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CompanyDetails::class)
     */
    public $company;

    /**
     * @var ArrayCollection & AgentDetails[]
     * @ODM\EmbedMany  (targetDocument=AgentDetails::class)
     */
    public $agents;

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
        $this->agents = new ArrayCollection;

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
     * @return AgentDetails|null
     */
    public function getAdminAgent(): ?AgentDetails
    {
        return collect($this->agents)->firstWhere('role', AgentDetails::ROLE_ADMIN);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'company' => toArrayOrNull($this->company),
            'agents' => collect($this->agents)->toArray(),
            'status' => $this->status,
        ]);
    }

    /**
     * @return TravelAgentAccountsRepository
     */
    public static function repository(): TravelAgentAccountsRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
