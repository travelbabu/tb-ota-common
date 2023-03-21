<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;

class AmenityRepository extends DocumentRepository
{
    public function getPropertyAmenityCategories(): Collection
    {
        return $this->getCollectionBy([
            '_id' => ['$regex' => 'PROPERTY:', '$options' => 'i'],
            'parentID' => ['$exists' => false]
        ], ['sortOrder' => 1]);
    }

    public function getSpaceAmenityCategories(): Collection
    {
        return $this->getCollectionBy([
            '_id' => ['$regex' => 'SPACE:', '$options' => 'i'],
            'parentID' => ['$exists' => false]
        ], ['sortOrder' => 1]);
    }
}
