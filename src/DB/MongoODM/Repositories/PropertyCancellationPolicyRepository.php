<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCancellationPolicy\PropertyCancellationPolicy;

class PropertyCancellationPolicyRepository extends DocumentRepository
{
    public function findActivePolicyForProperty(Property|int $property): ?PropertyCancellationPolicy
    {
        $criteria = [
            'propertyID' => Property::resolveID($property),
            'status' => PropertyCancellationPolicy::STATUS_ACTIVE
        ];
        $orderBy = ['createdAt' => -1];
        return $this->findOneBy($criteria, $orderBy);
    }

    public function getAllForProperty(Property|int $property, $criteria = [])
    {
        $criteria = array_merge(['propertyID' => Property::resolveID($property)], $criteria);
        $orderBy = ['createdAt' => -1];
        return $this->findOneBy($criteria, $orderBy);
    }
}
