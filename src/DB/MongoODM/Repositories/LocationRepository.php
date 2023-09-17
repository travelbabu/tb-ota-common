<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
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
     * @return Collection
     */
    public function getAllCountries(): Collection
    {
        $criteria = ['type' => Location::TYPE_COUNTRY];

        $orderBy = ['nane' => 1];

        return $this->getCollectionBy($criteria, $orderBy);
    }

    /**
     * @param string $countryId
     * @return Collection<Location>
     */
    public function getAllStatesForCountry(string $countryId): Collection
    {
        $criteria = [
            'type' => Location::TYPE_STATE,
            'country.id' => new ObjectId($countryId)
        ];

        $orderBy = ['name' => 1];

        return $this->getCollectionBy($criteria, $orderBy);
    }

    /**
     * @param string $stateId
     * @return Collection<Location>
     */
    public function getAllCitiesForState(string $stateId): Collection
    {
        $criteria = [
            'type' => Location::TYPE_CITY,
            'state.id' => new ObjectId($stateId)
        ];

        $orderBy = ['name' => 1];

        return $this->getCollectionBy($criteria, $orderBy);
    }

    /**
     * @param string $areaId
     * @return Collection<Location>
     */
    public function getAllAreasForState(string $areaId): Collection
    {
        $criteria = [
            'type' => Location::TYPE_AREA,
            'city.id' => new ObjectId($areaId)
        ];

        $orderBy = ['name' => 1];

        return $this->getCollectionBy($criteria, $orderBy);
    }

    /**
     * @param string $id
     * @param string $type
     * @return Location|null
     */
    public function findByIdAndType(string $id, string $type): Location|null
    {
        return $this->findOneBy([
            'id' => $id,
            'type' => $type
        ]);
    }

    /**
     * @param string $id
     * @return Location|null
     */
    public function findCountry(string $id): ?Location
    {
        return $this->findByIdAndType(
            $id,
            Location::TYPE_COUNTRY
        );
    }

    /**
     * @param string $id
     * @return Location|null
     */
    public function findState(string $id): ?Location
    {
        return $this->findByIdAndType(
            $id,
            Location::TYPE_STATE
        );
    }

    /**
     * @param string $id
     * @return Location|null
     */
    public function findCity(string $id): ?Location
    {
        return $this->findByIdAndType(
            $id,
            Location::TYPE_CITY
        );
    }

    /**
     * @param string $id
     * @return Location|null
     */
    public function findArea(string $id): ?Location
    {
        return $this->findByIdAndType(
            $id,
            Location::TYPE_AREA
        );
    }
}
