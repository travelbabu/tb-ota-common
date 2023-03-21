<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Doctrine\ODM\MongoDB\MongoDBException;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDetails\PropertyDetails;
use function SYSOTEL\OTA\Common\Helpers\documentManager;

class PropertyDetailsRepository extends DocumentRepository
{
    /**
     * @param Property $property
     * @return PropertyDetails
     * @throws LockException
     * @throws MappingException
     * @throws MongoDBException
     */
    public function firstOrNew(Property $property): PropertyDetails
    {
        $document = $this->find($property->id);

        if(!$document) {
            $document = new PropertyDetails(['id' => $property->id, 'supplierID' => $property->supplierID]);
            documentManager()->persist($document);
            documentManager()->flush();
        }

        return $document;
    }
}
