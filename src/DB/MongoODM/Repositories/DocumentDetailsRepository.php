<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyBankDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\PropertyDocumentDetails;

abstract class DocumentDetailsRepository extends DocumentRepository
{
    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return PropertyDocumentDetails|null
     */
    public function findLatestForProperty(int|Property $property, array $criteria = [], array $sort = []): null|PropertyDocumentDetails
    {
        $criteria = array_merge([
            'propertyID' => Property::resolveID($property)
        ], $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->findOneBy($criteria, $sort);
    }
}
