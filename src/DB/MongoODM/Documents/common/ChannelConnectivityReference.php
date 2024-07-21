<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity\ChannelConnectivity;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class ChannelConnectivityReference extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Id
     */
    public $_id;

    public static function createFromConnectivity(ChannelConnectivity $connectivity): ChannelConnectivityReference
    {
        return new self([
            '_id' => $connectivity->id
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->_id
        ]);
    }
}
