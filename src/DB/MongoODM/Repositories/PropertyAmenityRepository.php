<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;

class PropertyAmenityRepository extends DocumentRepository
{
    public function getAllForProperty(Property|int $property, array $criteria = [], array $orderBy = []): Collection
    {
        $criteria = array_merge($criteria, [
            'propertyID' => Property::resolveID($property),
            'spaceID' => ['$exists' => false]
        ]);

        return $this->getCollectionBy($criteria, $orderBy);
    }

    public function getAllForPropertySpace(Property|int $property, PropertySpace|int $space, array $criteria = [], array $orderBy = []): Collection
    {
        $criteria = array_merge($criteria, [
            'propertyID' => Property::resolveID($property),
            'spaceID' => PropertySpace::resolveID($space),
        ]);

        return $this->getCollectionBy($criteria, $orderBy);
    }
}
