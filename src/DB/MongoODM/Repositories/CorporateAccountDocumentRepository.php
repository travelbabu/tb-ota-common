<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount\CorporateAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount\CorporateAccountBranch;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount\CorporateAccountDocument;

class CorporateAccountDocumentRepository extends DocumentRepository
{
    /**
     * @param CorporateAccount|int $account
     * @param string $type
     * @param array $criteria
     * @param array $sort
     * @return CorporateAccountDocument|null
     */
    public function findLatestCompanyDocument(CorporateAccount|int $account, string $type, array $criteria = [], array $sort = []): ?CorporateAccountDocument
    {
        $criteria = array_merge([
            'accountID' => CorporateAccount::resolveID($account),
            'branchID' => ['$exists' => false],
            'details.docType' => $type
        ], $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->findOneBy($criteria, $sort);
    }

    /**
     * @param CorporateAccountBranch|int $branch
     * @param string $type
     * @param array $criteria
     * @param array $sort
     * @return CorporateAccountDocument|null
     */
    public function findActiveCompanyDocument(CorporateAccountBranch|int $branch, string $type, array $criteria = [], array $sort = []): ?CorporateAccountDocument
    {
        $document = $this->findLatestCompanyDocument($branch, $type, $criteria, $sort);

        if($document && $document->verification->status === Verification::STATUS_APPROVED) {
            return $document;
        }

        return null;
    }

    /**
     * @param CorporateAccountBranch|int $branch
     * @param string $type
     * @param array $criteria
     * @param array $sort
     * @return CorporateAccountDocument|null
     */
    public function findLatestBranchDocument(CorporateAccountBranch|int $branch, string $type, array $criteria = [], array $sort = []): ?CorporateAccountDocument
    {
        $criteria = array_merge([
            'branchID' => CorporateAccountBranch::resolveID($branch),
            'details.docType' => $type
        ], $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->findOneBy($criteria, $sort);
    }

    /**
     * @param CorporateAccountBranch|int $branch
     * @param string $type
     * @param array $criteria
     * @param array $sort
     * @return CorporateAccountDocument|null
     */
    public function findActiveBranchDocument(CorporateAccountBranch|int $branch, string $type, array $criteria = [], array $sort = []): ?CorporateAccountDocument
    {
        $document = $this->findLatestBranchDocument($branch, $type, $criteria, $sort);

        if($document && $document->verification->status === Verification::STATUS_APPROVED) {
            return $document;
        }

        return null;
    }
}
