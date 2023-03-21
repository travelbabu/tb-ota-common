<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyChannelConnection;

class PropertyChannelConnectionsRepository extends DocumentRepository
{
    /**
     * @param int|Property $property
     * @param string|Channel $baseChannel
     * @param string|Channel $connectedChannel
     * @return PropertyChannelConnection|null
     */
    public function findConnection(int|Property $property, string|Channel $baseChannel, string|Channel $connectedChannel): ?PropertyChannelConnection
    {
        $connectedChannelID = Channel::resolveID($connectedChannel);
        $baseChannelID = Channel::resolveID($baseChannel);
        $propertyID = Property::resolveID($property);

        return $this->findOneBy([
            'propertyID' => $propertyID,
            'baseChannelID' => $baseChannelID,
            'connectedChannelID' => $connectedChannelID,
        ]);
    }

    /**
     * @param int|Property $property
     * @param string|Channel $baseChannel
     * @param array $criteria
     * @return Collection
     */
    public function getActiveConnections(int|Property $property, string|Channel $baseChannel, array $criteria = []): Collection
    {
        $baseChannelID = Channel::resolveID($baseChannel);
        $propertyID = Property::resolveID($property);

        $criteria = array_merge([
            'propertyID' => $propertyID,
            'baseChannelID' => $baseChannelID,
            'status' => PropertyChannelConnection::STATUS_ACTIVE
        ],$criteria);

        return collect($this->findBy($criteria));
    }
}
