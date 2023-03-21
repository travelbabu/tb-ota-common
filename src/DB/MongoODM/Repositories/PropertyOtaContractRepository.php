<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyOtaContract\PropertyOtaContract;

class PropertyOtaContractRepository extends DocumentRepository
{
    /**
     * @param Property|int $property
     * @param array $filters
     * @return PropertyOtaContract|null
     */
    public function findLatestContract(Property|int $property, array $filters = []): ?PropertyOtaContract
    {
        $criteria = array_merge($filters, ['propertyID' => Property::resolveID($property)]);
        $sort = ['createdAt' => -1];

        return $this->findOneBy($criteria, $sort);
    }

    /**
     * @param Property|int $property
     * @return Collection
     */
    public function getAllContracts(Property|int $property, $sortBy = 'ASC'): Collection
    {
        $criteria = ['propertyID' => Property::resolveID($property)];
        $orderBy = ['createdAt' => $sortBy === 'DESC' ? -1 : 1];

        return $this->getCollectionBy($criteria, $orderBy);
    }

    /**
     * @param Property|int $property
     * @return PropertyOtaContract|null
     */
    public function findActiveContract(Property|int $property): ?PropertyOtaContract
    {
        $criteria = [
            'propertyID' => Property::resolveID($property),
            'status' => PropertyOtaContract::STATUS_ACTIVE
        ];

        $sort = ['createdAt' => -1];

        return $this->findOneBy($criteria, $sort);
    }
}
