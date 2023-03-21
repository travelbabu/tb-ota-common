<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM\AccessRights;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

class PropertyRepository extends DocumentRepository
{
    /**
     * @param string $id
     * @return Property|null
     */
    public function findByTgrID(string $id): ?Property
    {
        return $this->findOneBy([
            'tgrDetails.id' => $id
        ]);
    }

    /**
     * @param string $slug
     * @return Property|null
     */
    public function findBySlug(string $slug): ?Property
    {
        return $this->findOneBy([
            'slug' => $slug
        ]);
    }

    /**
     * @param User|int $user
     * @param array $criteria
     * @return Collection
     */
    public function getAllForUser(User|int $user, array $criteria = []): Collection
    {
        $documents = AccessRights::repository()->getAllPropertyRightsForUser($user);

        if($user->type !== User::TYPE_ADMIN) {
            $criteria['_id'] = ['$in' => []];
            foreach($documents as $document) {
                $criteria['_id']['$in'][] = $document->propertyID;
            }
        }

        return collect($this->findBy($criteria));
    }
}
