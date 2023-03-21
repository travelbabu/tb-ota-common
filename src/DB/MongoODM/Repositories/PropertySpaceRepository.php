<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;

class PropertySpaceRepository extends DocumentRepository
{
    /**
     * @param string $id
     * @param array $criteria
     * @param array $orderBy
     * @return PropertySpace|null
     */
    public function findByTgrID(string $id, array $criteria = [], array $orderBy = []): ?PropertySpace
    {
        $criteria = array_merge($criteria, [
            'tgrDetails.id' => $id
        ]);

        return $this->findOneBy($criteria, $orderBy);
    }

    /**
     * @param Property|int $property
     * @param array $criteria
     * @param array $orderBy
     * @return Collection
     */
    public function getAllForProperty(Property|int $property, array $criteria = [], array $orderBy = []): Collection
    {
        $criteria = array_merge($criteria, [
            'propertyID' => Property::resolveID($property)
        ]);

        $orderBy = array_merge([
            'status' => 1
        ], $orderBy);

        return $this->getCollectionBy($criteria, $orderBy);
    }

    /**
     * @param Property|int $property
     * @param array $criteria
     * @return Collection
     */
    public function getActiveSpacesForProperty(Property|int $property, array $criteria = []): Collection
    {
        return $this->getAllForProperty(
            $property,
            array_merge(['status' => PropertySpace::STATUS_ACTIVE], $criteria)
        );
    }

    /**
     * @param Property|int $property
     * @param array $criteria
     * @return Collection
     */
    public function getActiveAndDisabledSpacesForProperty(Property|int $property, array $criteria = []): Collection
    {
        return $this->getAllForProperty(
            $property,
            array_merge(['status' => ['$in' => [PropertySpace::STATUS_ACTIVE, PropertySpace::STATUS_DISABLED]]], $criteria)
        );
    }
}
