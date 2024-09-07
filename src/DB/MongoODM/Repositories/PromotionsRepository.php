<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\Helpers\Enums;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\Promotion;

class PromotionsRepository extends DocumentRepository
{
    public function findOfferById(string $id): Promotion|null
    {
        return $this->findOneBy([
            '_id' => $id,
            'category' => Enums::PROMOTION_CATEGORY_OFFER
        ]);
    }

    public function findPromoCodeById(string $id): Promotion|null
    {
        return $this->findOneBy([
            '_id' => $id,
            'category' => Enums::PROMOTION_CATEGORY_PROMO_CODE
        ]);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection<Promotion>
     */
    public function getAllOffersForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge(
            [
                'propertyID' => Property::resolveID($property),
                'category' => Enums::PROMOTION_CATEGORY_OFFER,
                'isExpired' => false,
            ],
            $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->getCollectionBy($criteria, $sort);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection<Promotion>
     */
    public function getAllPromoCodesForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge(
            [
                'propertyID' => Property::resolveID($property),
                'category' => Enums::PROMOTION_CATEGORY_PROMO_CODE,
                'isExpired' => false,
            ],
            $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->getCollectionBy($criteria, $sort);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection<Promotion>
     */
    public function getAllForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge(
            [
                'propertyID' => Property::resolveID($property),
                'isExpired' => false
            ],
            $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->getCollectionBy($criteria, $sort);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection<Promotion>
     */
    public function getActiveOffersForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge(
            [
                'propertyID' => Property::resolveID($property),
                'status' => Promotion::STATUS_ACTIVE,
                'category' => Enums::PROMOTION_CATEGORY_OFFER,
                'isExpired' => false
            ],
            $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->getCollectionBy($criteria, $sort);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection<Promotion>
     */
    public function getActivePromoCodesForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge(
            [
                'propertyID' => Property::resolveID($property),
                'status' => Promotion::STATUS_ACTIVE,
                'category' => Enums::PROMOTION_CATEGORY_PROMO_CODE,
                'isExpired' => false
            ],
            $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->getCollectionBy($criteria, $sort);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection<Promotion>
     */
    public function getActiveAndDisableForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge(
            [
                'propertyID' => Property::resolveID($property),
                'status' => Promotion::STATUS_ACTIVE,
                'isExpired' => false
            ],
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
    public function findLatestOfferByPromoId(int $promoID, string $type, array $criteria = [], array $sort = []): null|Promotion
    {
        $criteria = array_merge([
            'promoID' => $promoID,
            'type' => $type,
            'isExpired' => false,
            'category' => Enums::PROMOTION_CATEGORY_OFFER,
        ], $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->findOneBy($criteria, $sort);
    }

    /**
     * @param int $promoID
     * @param string $type
     * @param array $criteria
     * @param array $sort
     * @return Promotion|null
     */
    public function findLatestPromoCodeByPromoId(int $promoID, string $type, array $criteria = [], array $sort = []): null|Promotion
    {
        $criteria = array_merge([
            'promoID' => $promoID,
            'type' => $type,
            'isExpired' => false,
            'category' => Enums::PROMOTION_CATEGORY_PROMO_CODE,
        ], $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->findOneBy($criteria, $sort);
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
