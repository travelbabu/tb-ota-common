<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\City;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\State;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;

class CityRepository extends DocumentRepository
{
    /**
     * @param string $id
     * @return City|null
     */
    public function findByTgrID(string $id): ?City
    {
        return $this->findOneBy([
            'supplierDetails.tgr.id' => $id
        ]);
    }

    public function getForState(string|State $state, array $criteria = [], array $orderBy = []): Collection
    {
        $stateID = $state instanceof State ? $state->id : $state;

        $criteria = array_merge([
            'state.id' => new ObjectId($stateID)
        ], $criteria);

        $orderBy = array_merge([
            'name' => 1
        ], $orderBy);

        return $this->getCollectionBy($criteria, $orderBy);
    }

    /**
     * @param string $slug
     * @return City|null
     */
    public function findBySlug(string $slug): ?City
    {
        return $this->findOneBy(compact('slug'));
    }
}
