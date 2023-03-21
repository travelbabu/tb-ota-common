<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ChannelLogApiCall extends EmbeddedDocument
{
    /**
     * @ODM\ReferenceOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelApiLog\ChannelApiLog::class)
     */
    public $apiLogID;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'apiLogID' => $this->apiLogID,
        ]);
    }
}
