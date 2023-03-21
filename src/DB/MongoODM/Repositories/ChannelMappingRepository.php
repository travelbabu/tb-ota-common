<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\ChannelMapping;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;

class ChannelMappingRepository extends DocumentRepository
{
    /**
     * @param int|Property $property
     * @param string|Channel $baseChannelID
     * @param string|Channel $connectedChannelID
     * @return ChannelMapping|null
     */
    public function findLatestFor(int|Property $property, string|Channel $baseChannelID, string|Channel $connectedChannelID): ?ChannelMapping
    {
        $propertyID = Property::resolveID($property);
        $baseChannelID = ($baseChannelID instanceof Channel) ? $baseChannelID->id : $baseChannelID;
        $connectedChannelID = ($connectedChannelID instanceof Channel) ? $connectedChannelID->id : $connectedChannelID;

        return$this->findOneBy(
            [
                'propertyID' => $propertyID,
                'baseChannelID' => $baseChannelID,
                'connectedChannelID' => $connectedChannelID
            ],
            [
                'createdAt' => -1
            ]
        );
    }
}
