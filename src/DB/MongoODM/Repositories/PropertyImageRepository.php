<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Illuminate\Support\Collection;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;

class PropertyImageRepository extends DocumentRepository
{
    /**
     * @param string $url
     * @param array $criteria
     * @param array $orderBy
     * @return PropertyImage|null
     */
    public function findByTgrUrl(string $url, array $criteria = [], array $orderBy = []): ?PropertyImage
    {
        $criteria = array_merge($criteria, [
            'tgrDetails.url' => $url
        ]);

        return $this->findOneBy($criteria, $orderBy);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @return Collection
     */
    public function getAllPropertyImages(int|Property $property, array $criteria = []): Collection
    {
        $propertyID = Property::resolveID($property);

        $criteria = array_merge([
            'propertyID' => $propertyID,
            'deletedAt' => ['$exists' => false]
        ], $criteria);

        $orderBy = [
            'isFeatured' => -1,
            'createdAt' => 1
        ];

        return collect(PropertyImage::repository()->findBy($criteria, $orderBy));
    }

    /**
     * @param int|Property $property
     * @return Collection
     */
    public function getPropertyImages(int|Property $property): Collection
    {
        return $this->getAllPropertyImages($property, ['spaceID' => null]);
    }

    /**
     * @param int|Property $property
     * @return Collection
     */
    public function getVerifiedPropertyImages(int|Property $property): Collection
    {
        return $this->getAllPropertyImages($property, [
            'spaceID' => null,
            'verification.status' => Verification::STATUS_APPROVED
        ]);
    }

    /**
     * @param int|Property $property
     * @param int|PropertySpace $space
     * @return Collection
     */
    public function getSpaceImages(int|Property $property, int|PropertySpace $space): Collection
    {
        $spaceID = PropertySpace::resolveID($space);

        return $this->getAllPropertyImages($property, [
            'spaceID' => $spaceID
        ]);
    }

    /**
     * @param int|Property $property
     * @param int|PropertySpace $space
     * @return Collection
     */
    public function getVerifiedSpaceImages(int|Property $property, int|PropertySpace $space): Collection
    {
        $spaceID = PropertySpace::resolveID($space);

        return $this->getAllPropertyImages($property, [
            'spaceID' => $spaceID,
            'verification.status' => Verification::STATUS_APPROVED
        ]);
    }
}
