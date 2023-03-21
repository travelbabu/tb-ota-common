<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount\AgentAccount;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;

class TravelAgentAccountsRepository extends DocumentRepository
{
    /**
     * @param AgentAccount|int $account
     * @param array $filters
     * @param array $sort
     * @return Collection
     */
    public function getByAccountID(AgentAccount|int $account, array $filters = [], array $sort = []): Collection
    {
        $filters = array_merge([
            'agentAccountID' => AgentAccount::resolveID($account),
        ], $filters);


        return $this->getCollectionBy($filters, $sort);
    }
}
