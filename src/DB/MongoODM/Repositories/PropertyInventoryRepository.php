<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Carbon\Carbon;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyInventory\PropertyInventory;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;

class PropertyInventoryRepository extends DocumentRepository
{
    public function findLatest(PropertySpace|int $space, Carbon $date, Channel|string $connectedChannel, Channel|string $baseChannel = null): ?PropertyInventory
    {
        $spaceID = PropertySpace::resolveID($space);
        $connectedChannelID = Channel::resolveID($connectedChannel);
        $date->startOfDay();

        $criteria = [
            'spaceID'            => $spaceID,
            'connectedChannelID' => $connectedChannelID,
            'startDate'          => [ '$lte' => $date ],
            'endDate'            => [ '$gte' => $date ],
            'status'             => PropertyInventory::STATUS_SUCCESS
        ];

        if(isset($baseChannel)) {
            $criteria['baseChannelID'] = Channel::resolveID($baseChannel);
        }

        $sort = ['createdAt' => -1];

        return $this->findOneBy($criteria, $sort);
    }
}