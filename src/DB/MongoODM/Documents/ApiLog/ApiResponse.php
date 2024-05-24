<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class ApiResponse extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $httpStatusCode;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $payloadFormat;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $payload;

    /**
     * @var ?array
     * @ODM\Field(type="obejct")
     */
    public $headers;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([]);
    }
}
