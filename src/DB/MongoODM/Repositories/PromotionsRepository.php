<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\Promotion;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;

class PromotionsRepository extends DocumentRepository
{
    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection<Promotion>
     */
    public function getActiveAndDisableForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {

        $criteria = array_merge(
            ['propertyID' => Property::resolveID($property),
                'isExpired' => false],
            $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->getCollectionBy($criteria, $sort);
    }

    /**
     * @param int $promoID
     * @param string $type
     * @param array $criteria
     * @param array $sort
     * @return Promotion|null
     */
    public function findLatestBy(int $promoID, string $type, array $criteria = [], array $sort = []): null|Promotion
    {
        $criteria = array_merge([
            'promoID' => $promoID, 'type' => $type, 'isExpired' => false
        ], $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->findOneBy($criteria, $sort);
    }
}