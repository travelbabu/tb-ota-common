<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\Location;

class LocationRepository extends DocumentRepository
{
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
            'country.id' => $countryId
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
            'country.id' => $stateId
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
            'country.id' => $areaId
        ];

        $orderBy = ['name' => 1];

        return $this->findBy($criteria, $orderBy);
    }
}
