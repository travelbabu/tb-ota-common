<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount\AgentAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccountDocument\AgentAccountDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;

class TravelAgentDocumentRepository extends DocumentRepository
{
    /**
     * @param AgentAccount|int $int
     * @param string $docType
     * @param array $filters
     * @param array $sort
     * @return AgentAccountDocument|null
     */
    public function findLatestForAccount(AgentAccount|int $int, string $docType, array $filters = [], array $sort = []): ?AgentAccountDocument
    {
        $criteria = array_merge([
            'travelAgentAccountID' => AgentAccount::resolveID($int),
            'details.docType' => $docType
        ], $filters);

        $sort = array_merge_recursive(['createdAt' => -1], $sort);

        return $this->findOneBy($criteria, $sort);
    }

    /**
     * @param AgentAccount|int $int
     * @param string $docType
     * @param array $filters
     * @param array $sort
     * @return AgentAccountDocument|null
     */
    public function findActiveForAccount(AgentAccount|int $int, string $docType, array $filters = [], array $sort = []): ?AgentAccountDocument
    {
        $document = $this->findLatestForAccount($int, $docType, $filters, $sort);

        if($document && $document->verification->status === Verification::STATUS_APPROVED) {
            return $document;
        }

        return null;
    }
}
