<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog\ApiLog;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class ApiLogReference extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Id
     */
    public $_id;

    /**
     * @param ApiLog $apiLog
     * @return ApiLogReference
     */
    public static function createFromApiLog(ApiLog $apiLog): ApiLogReference
    {
        $ref = new self();
        $ref->_id = $apiLog->id;

        return $ref;
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
