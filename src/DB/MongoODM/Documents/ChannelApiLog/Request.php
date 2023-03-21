<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelApiLog;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class Request extends EmbeddedDocument
{
    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $headers;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $payload;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $payloadType;
    public const PAYLOAD_TYPE_JSON = 'JSON';
    public const PAYLOAD_TYPE_XML = 'XML';

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $statusCode;

    /**
     * @var carbon
     * @ODM\Field(type="carbon")
     */
    public $timestamp;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'headers'    => $this->headers,
            'payload'    => $this->payload,
            'payloadType'    => $this->payloadType,
            'statusCode' => $this->statusCode,
            'timestamp'  => $this->timestamp,
        ]);
    }
}
