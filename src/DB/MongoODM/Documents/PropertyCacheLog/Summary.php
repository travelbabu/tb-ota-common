<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCacheLog;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class Summary extends EmbeddedDocument
{
    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $startedAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $completedAt;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $cachePropertiesCount = 0;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $deletedPropertiesCount = 0;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'startedAt' => $this->startedAt,
            'completedAt' => $this->completedAt,
            'cachePropertiesCount' => $this->cachePropertiesCount,
            'deletedPropertiesCount' => $this->deletedPropertiesCount,
        ];
    }
}
