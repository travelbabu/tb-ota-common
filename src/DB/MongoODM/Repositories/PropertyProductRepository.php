<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;
use Illuminate\Support\Collection;

class PropertyProductRepository extends DocumentRepository
{
    /**
     * @param string $id
     * @param array $criteria
     * @param array $orderBy
     * @return PropertyProduct|null
     */
    public function findByTgrID(string $id, array $criteria = [], array $orderBy = []): ?PropertyProduct
    {
        $criteria = array_merge($criteria, [
            'tgrDetails.id' => $id
        ]);

        return $this->findOneBy($criteria, $orderBy);
    }

    /**
     * @param PropertySpace|int $space
     * @param array $criteria
     * @return Collection
     */
    public function getAllForSpace(PropertySpace|int $space, array $criteria = []): Collection
    {
        $spaceID = PropertySpace::resolveID($space);

        $criteria = array_merge($criteria,[
            'spaceID' => $spaceID
        ]);

        $products = $this->findBy($criteria, ['status' => 1]);

        return collect($products);
    }

    /**
     * @param PropertySpace|int $space
     * @param array $criteria
     * @return Collection
     */
    public function getActiveProductsForSpace(PropertySpace|int $space, array $criteria = []): Collection
    {
            return $this->getAllForSpace(
                $space,
                array_merge(['status' => PropertyProduct::STATUS_ACTIVE], $criteria)
            );
    }

    /**
     * @param PropertySpace|int $space
     * @param array $criteria
     * @return Collection
     */
    public function getActiveAndDisabledProductsForSpace(PropertySpace|int $space, array $criteria = []): Collection
    {
        return $this->getAllForSpace(
            $space,
            array_merge(['status' => ['$in' => [PropertyProduct::STATUS_ACTIVE, PropertyProduct::STATUS_DISABLED]]], $criteria)
        );
    }

    /**
     * @param Property|int $property
     * @param array $criteria
     * @return Collection
     */
    public function getActiveForProperty(Property|int $property, array $criteria = []): Collection
    {
        $propertyID = Property::resolveID($property);

        $criteria = array_merge($criteria, [
            'propertyID' => $propertyID,
            'status' => PropertyProduct::STATUS_ACTIVE
        ]);

        return collect($this->findBy($criteria));
    }

    /**
     * @param Property|int $property
     * @param array $criteria
     * @return Collection
     */
    public function getActiveAndDisabledForProperty(Property|int $property, array $criteria = []): Collection
    {
        $propertyID = Property::resolveID($property);

        $criteria = array_merge($criteria, [
            'propertyID' => $propertyID,
            'status' => ['$in' => [PropertyProduct::STATUS_ACTIVE, PropertyProduct::STATUS_DISABLED]]
        ]);

        return collect($this->findBy($criteria));
    }
}
