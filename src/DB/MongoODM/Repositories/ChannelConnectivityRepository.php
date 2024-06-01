<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity\ChannelConnectivity;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity\types\ResAvenue\ResAvenueConnectivity;
use SYSOTEL\OTA\Common\Helpers\Enums;

class ChannelConnectivityRepository extends DocumentRepository
{
    /**
     * @param string $channelID
     * @param int $propertyID
     * @return ChannelConnectivity|null
     */
    public function findByChannelIDAndPropertyID(string $channelID, int $propertyID): ?ChannelConnectivity
    {
        return ChannelConnectivity::repository()->findOneBy([
            'propertyID' => $propertyID,
            'channelID' => $channelID,
            'isExpired' => false
        ]);
    }


    /**
     * @param int $propertyID
     * @return ChannelConnectivity|null
     */
    public function findByResavenueConnectivityByPropertyID(int $propertyID): ?ResAvenueConnectivity
    {
        return $this->findByChannelIDAndPropertyID(Enums::CHANNEL_ID_RESAVENUE, $propertyID);
    }
}
