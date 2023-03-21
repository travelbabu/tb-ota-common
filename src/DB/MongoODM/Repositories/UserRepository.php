<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount\AgentAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount\CorporateAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM\AccessRights;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Agent\Agent;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

class UserRepository extends DocumentRepository
{
    /**
     * @param string $email
     * @param string $type
     * @return User|null
     */
    public function getOneByEmail(string $email, string $type): ?User
    {
        return $this->findOneBy([
            'type' => $type,
            'email.id' => $email
        ]);
    }

    /**
     * @param string $mobile
     * @param string $type
     * @return User|null
     */
    public function getOneByMobile(string $mobile, string $type): ?User
    {
        return $this->findOneBy([
            'type' => $type,
            'mobile.number' => $mobile
        ]);
    }

    /**
     * @param string $mobile
     * @param string $email
     * @param string $type
     * @return User|null
     */
    public function getOneByEmailAndMobile(string $email, string $mobile, string $type): ?User
    {
        return $this->findOneBy([
            'type' => $type,
            'mobile.number' => $mobile,
            'email.id' => $mobile,
        ]);
    }

    /**
     * @param array $criteria
     * @param array $sort
     * @return Collection
     */
    public function getAllExtranetUsers(array $criteria = [], array $sort = []): Collection
    {
        return $this->getCollectionBy($criteria, $sort);
    }

    /**
     * Get all users that are assigned to given property
     *
     * @param Property|int $property
     * @param array $criteria
     * @return Collection
     */
    public function getAllForProperty(Property|int $property, array $criteria = []): Collection
    {
        $documents = AccessRights::repository()->getAllUserRightsForProperty($property);

        $criteria['_id'] = ['$in' => []];
        foreach($documents as $document) {
            $criteria['_id']['$in'][] = $document->userID;
        }
        return collect($this->findBy($criteria));
    }

    /**
     * @param Property|int $property
     * @return Collection
     */
    public function getExtranetUsersForProperty(Property|int $property): Collection
    {
        return $this->getAllForProperty($property, [
            'type' => User::TYPE_EXTRANET_USER
        ]);
    }

    /**
     * @param Property|int $property
     * @return Collection
     */
    public function getAdminUsersForProperty(Property|int $property): Collection
    {
        return $this->getAllForProperty($property, [
            'type' => User::TYPE_ADMIN
        ]);
    }

    /**
     * @param AgentAccount $account
     * @return User|null
     */
    public function getAdminAgentForAccount(AgentAccount $account): ?Agent
    {
        $agentDetails = $account->getAdminAgent();

        if(!$agentDetails) return null;

        $agentDetails = $account->getAdminAgent();

        /** @var Agent $agent */
        return $this->findOneBy([
            'id' => new ObjectId($agentDetails->id),
            'type' => User::TYPE_AGENT,
        ]);
    }

    /**
     * @param AgentAccount|int $account
     * @return Agent[]
     */
    public function getAllAgentsForAccount(AgentAccount|int $account): array
    {
        return $this->findBy([
            'agentAccountID' => AgentAccount::resolveID($account),
            'type' => User::TYPE_AGENT,
        ]);
    }

    /**
     * @param CorporateAccount|int $account
     * @return Agent[]
     */
    public function getAllCorporateUsersForAccount(CorporateAccount|int $account): array
    {
        return $this->findBy([
            'corporateAccountID' => CorporateAccount::resolveID($account),
            'type' => User::TYPE_CORPORATE_USER,
        ]);
    }
}
