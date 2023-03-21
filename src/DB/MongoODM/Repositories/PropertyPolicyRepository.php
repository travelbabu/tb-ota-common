<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;

class PropertyPolicyRepository extends DocumentRepository
{
    public function findLatest(int|Property $property, array $criteria = [])
    {
        $propertyID = Property::resolveID($property);
        $criteria = array_merge(['propertyID' => $propertyID], $criteria);
        $sort = ['createdAt' => -1];

        return $this->findOneBy($criteria, $sort);
    }
}
