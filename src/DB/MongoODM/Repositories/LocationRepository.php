<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\Location;

class LocationRepository extends DocumentRepository
{
    /**
     * @return Location
     */
    public function getIndiaCountry(): Location
    {
        return $this->findOneBy([
            'type' => Location::TYPE_COUNTRY,
            'code' => 'IND'
        ]);
    }

    /**
     * @return array
     */
    public function getAllCountries(): array
    {
        $criteria = ['type' => Location::TYPE_COUNTRY];

        $orderBy = ['nane' => 1];

        return $this->findBy($criteria, $orderBy);
    }

    /**
     * @param string $countryId
     * @return array<Location>
     */
    public function getAllStatesForCountry(string $countryId): array
    {
        $criteria = [
            'type' => Location::TYPE_STATE,
            'country.id' => new ObjectId($countryId)
        ];

        $orderBy = ['name' => 1];

        return $this->findBy($criteria, $orderBy);
    }

    /**
     * @param string $stateId
     * @return array<Location>
     */
    public function getAllCitiesForState(string $stateId): array
    {
        $criteria = [
            'type' => Location::TYPE_CITY,
            'country.id' => new ObjectId($stateId)
        ];

        $orderBy = ['name' => 1];

        return $this->findBy($criteria, $orderBy);
    }

    /**
     * @param string $areaId
     * @return array<Location>
     */
    public function getAllAreasForState(string $areaId): array
    {
        $criteria = [
            'type' => Location::TYPE_AREA,
            'country.id' => new ObjectId($areaId)
        ];

        $orderBy = ['name' => 1];

        return $this->findBy($criteria, $orderBy);
    }
}
