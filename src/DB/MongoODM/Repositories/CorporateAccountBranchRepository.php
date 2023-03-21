<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount\CorporateAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount\CorporateAccountBranch;

class CorporateAccountBranchRepository extends DocumentRepository
{
    /**
     * @param CorporateAccount|int $account
     * @param array $criteria
     * @param array $sort
     * @return CorporateAccountBranch[]
     */
    public function findAllForAccount(CorporateAccount|int $account, array $criteria = [], array $sort = []): array
    {
        $criteria = array_merge([
            'accountID' => CorporateAccount::resolveID($account)
        ], $criteria);

        return $this->findBy($criteria, $sort);
    }

    /**
     * @param CorporateAccount|int $account
     * @param array $criteria
     * @param array $sort
     * @return CorporateAccountBranch[]
     */
    public function findActiveBranchesForAccount(CorporateAccount|int $account, array $criteria = [], array $sort = []): array
    {
        $criteria = array_merge([
            'status' => CorporateAccountBranch::STATUS_ACTIVE
        ], $criteria);

        return $this->findAllForAccount($account, $criteria, $sort);
    }
}
