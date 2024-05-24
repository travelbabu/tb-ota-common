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
class ApiRequest extends EmbeddedDocument
{
    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $httpMethod;

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
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $host;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $path;

    /**
     * @var ?boolean
     * @ODM\Field(type="bool")
     */
    public $isSecure;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $url;

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
