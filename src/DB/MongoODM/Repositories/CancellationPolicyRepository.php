<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy\CancellationPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;

class CancellationPolicyRepository extends DocumentRepository
{
    /**
     * @param int|Property $property
     * @param array $criteria
     * @return Collection
     */
    public function getAllForProperty(int|Property $property, array $criteria = []): Collection
    {
        $propertyID = Property::resolveID($property);

        $criteria = array_merge([
            'propertyID' => $propertyID,
            'status' => ['$ne' => CancellationPolicy::STATUS_DELETED]
        ],$criteria);

        return collect($this->findBy($criteria));
    }

    /**
     * @param PropertySpace $space
     * @param array $criteria
     * @return Collection
     */
    public function getAllForSpace(PropertySpace $space, array $criteria = []): Collection
    {
        $spaceID = PropertySpace::resolveID($space);

        $criteria = array_merge(compact('spaceID'),$criteria);

        return collect($this->findBy($criteria));
    }
}
