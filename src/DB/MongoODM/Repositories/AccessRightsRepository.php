<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM\AccessRights;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

class AccessRightsRepository extends DocumentRepository
{

    /**
     * @param int|User $user
     * @return Collection
     */
    public function getAllAccessRights(int|User $user): Collection
    {
        $criteria = [
            'userID' => User::resolveID($user),
        ];

        return $this->findOneBy($criteria);
    }

    /**
     * @param int|User $user
     * @return AccessRights|null
     */
    public function findUserRights(int|User $user): ?AccessRights
    {
        $criteria = [
            'userID' => User::resolveID($user),
            'propertyID' => ['$exists' => false]
        ];

        return $this->findOneBy($criteria);
    }

    /**
     * @param int|User $user
     * @param int|Property $property
     * @return AccessRights|null
     */
    public function findUserPropertyRights(int|User $user, int|Property $property): ?AccessRights
    {
        $criteria = [
            'userID' => User::resolveID($user),
            'propertyID' => Property::resolveID($property)
        ];

        return $this->findOneBy($criteria);
    }

    /**
     * @param int|User $user
     * @return Collection
     */
    public function getAllPropertyRightsForUser(int|User $user): Collection
    {
        $criteria = [
            'userID' => User::resolveID($user),
            'propertyID' => ['$exists' => true]
        ];

        return collect($this->findBy($criteria));
    }


    /**
     * @param int|Property $property
     * @return Collection
     */
    public function getAllUserRightsForProperty(int|Property $property): Collection
    {
        $criteria = [
            'propertyID' => Property::resolveID($property),
        ];

        return collect($this->findBy($criteria));
    }
}
