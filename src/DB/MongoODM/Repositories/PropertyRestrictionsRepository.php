<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Carbon\Carbon;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyRestrictions\PropertyRestrictions;

class PropertyRestrictionsRepository extends DocumentRepository
{
    public function findLatest(PropertyProduct|int $product, Carbon $date, Channel|string $connectedChannel, Channel|string $baseChannel = null): ?PropertyRestrictions
    {
        $productID = PropertyProduct::resolveID($product);
        $connectedChannelID = Channel::resolveID($connectedChannel);
        $date->startOfDay();

        $criteria = [
            'productID'          => $productID,
            'connectedChannelID' => $connectedChannelID,
            'startDate'          => [ '$lte' => $date ],
            'endDate'            => [ '$gte' => $date ],
            'status'             => PropertyRestrictions::STATUS_SUCCESS
        ];

        if(isset($baseChannel)) {
            $criteria['baseChannelID'] = Channel::resolveID($baseChannel);
        }

        $sort = ['createdAt' => -1];

        return $this->findOneBy($criteria, $sort);
    }
}
