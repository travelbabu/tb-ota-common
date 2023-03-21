<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount\AgentAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccountSettings\AgentAccountSettings;

class AgentAccountSettingsRepository extends DocumentRepository
{
    /**
     * @param AgentAccount|int $account
     * @return AgentAccountSettings[]
     */
    public function findAllSettings(AgentAccount|int $account): array
    {
        $criteria = ['agentAccountID' => AgentAccount::resolveID($account)];
        $sort = ['createdAt' => -1];

        return $this->findBy($criteria, $sort);
    }

    /**
     * @param AgentAccount|int $account
     * @return AgentAccountSettings|null
     */
    public function findActiveSettings(AgentAccount|int $account): ?AgentAccountSettings
    {
        $criteria = ['agentAccountID' => AgentAccount::resolveID($account)];
        $sort = ['createdAt' => -1];

        $settings = $this->findOneBy($criteria, $sort);

        return $settings && $settings->status === AgentAccountSettings::STATUS_ACTIVE
            ? $settings
            : null;
    }
}
