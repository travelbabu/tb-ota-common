<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Carbon\Carbon;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyInventory\PropertyInventory;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyRate\PropertyRate;
use function SYSOTEL\OTA\Common\Helpers\carbonToUTCDateTime;

class PropertyRateRepository extends DocumentRepository
{
    public function findLatest(PropertyProduct|int $product, Carbon $date, Channel|string $connectedChannel, Channel|string $baseChannel = null): ?PropertyRate
    {
        $productID = PropertyProduct::resolveID($product);
        $connectedChannelID = Channel::resolveID($connectedChannel);
        $date->startOfDay();

        $criteria = [
            'productID'          => $productID,
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
