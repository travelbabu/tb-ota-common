<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;

class ChannelPropertyRepository extends DocumentRepository
{
    public function findLatest(string|Channel $channel, int|Property $property)
    {
        $channelID = Channel::resolveID($channel);
        $propertyID = Property::resolveID($property);

        $criteria = [
            'internalPropertyID' => $propertyID,
            'channelID' => $channelID,
        ];

        $sort = [
            'createdAt' => -1
        ];

        return $this->findOneBy($criteria,$sort);
    }
}
