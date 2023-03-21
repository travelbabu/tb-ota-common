<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccountSettings;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AgentAccountSettingsRepository;

/**
 * @ODM\Document(
 *     collection="agentAccountSettings",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AgentAccountSettingsRepository::class
 * ),
 * @ODM\HasLifecycleCallbacks
 */
class AgentAccountSettings extends Document
{
    use HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'agentAccounts';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $agentAccountID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_EXPIRED = 'EXPIRED';

    /**
     * @var AgentCommission
     * @ODM\EmbedOne(targetDocument=AgentCommission::class)
     */
    public $commission;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $causer;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    protected $defaults = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([

        ]);
    }

    /**
     * @return AgentAccountSettingsRepository
     */
    public static function repository(): AgentAccountSettingsRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
