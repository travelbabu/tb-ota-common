<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyDocument;
use SYSOTEL\OTA\Common\Enums\PropertyDocumentType;

class PropertyDocumentRepository extends DocumentRepository
{
    /**
     * @param int|Property $property
     * @param PropertyDocumentType $type
     * @param array $criteria
     * @param array $sort
     * @return PropertyDocument|null
     */
    public function findLatestForProperty(int|Property $property, PropertyDocumentType $type, array $criteria = [], array $sort = []): null|PropertyDocument
    {
        $criteria = array_merge([
            'propertyID' => Property::resolveID($property),
            'type' => $type->value
        ], $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->findOneBy($criteria, $sort);
    }
}
