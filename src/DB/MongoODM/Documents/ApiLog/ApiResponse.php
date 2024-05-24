<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use GuzzleHttp\Psr7\Request;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Psr\Http\Message\ResponseInterface;

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
     * @ODM\Field(type="raw")
     */
    public $headers;

    public static function createFromResponse(ResponseInterface $response)
    {
        $response->getBody()->rewind();
        
        $instance = new self;
        $instance->httpStatusCode = $response->getStatusCode();
        $instance->payload = $response->getBody()->getContents();
        $instance->setHeadersFromResponse($response);
        
        $response->getBody()->rewind();
        
        return $instance;
    }

     /**
     * @param ResponseInterface $request
     * @return $this
     */
    public function setHeadersFromResponse(ResponseInterface $response): static
    {
        $this->headers = [];

        foreach ($response->getHeaders() as $key => $value) {
            $this->headers[$key] = is_array($value) ? implode(',', $value) : $value;
        }
        
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([]);
    }
}
