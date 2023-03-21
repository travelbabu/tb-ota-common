<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyFAQ\PropertyFAQ;

class PropertyFAQRepository extends DocumentRepository
{
    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection
     */
    public function getAllForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge([
            'propertyID' => Property::resolveID($property),
        ], $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->getCollectionBy($criteria, $sort);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection
     */
    public function getAllAvailableForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge([
            'deletedAt' => ['$exists' => false]
        ], $criteria);

        return $this->getAllForProperty($property, $criteria, $sort);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection
     */
    public function getActiveFAQsForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge([
            'status' => PropertyFAQ::STATUS_ACTIVE
        ], $criteria);

        return $this->getAllForProperty($property, $criteria, $sort);
    }
}
