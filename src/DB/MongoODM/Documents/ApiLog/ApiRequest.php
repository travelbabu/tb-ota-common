<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Str;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class ApiRequest extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
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
    public $port;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $url;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $clientIp;

    /**
     * @var ?array
     * @ODM\Field(type="raw")
     */
    public $clientIps;

    /**
     * @var ?array
     * @ODM\Field(type="raw")
     */
    public $headers;

    public static function createFromGuzzleRequest(Request $request)
    {
        $instance = new self();

        $instance->httpMethod = $request->getMethod();
        $instance->payloadFormat = $request->getBody()->getContents() ?? '';
        $instance->host = $request->getUri()->getHost();
        $instance->path = $request->getUri()->getPath();
        $instance->port = $request->getUri()->getPort();
        $instance->url = $request->getUri()->__toString();
        $instance->setHeadersFromGuzzleRequest($request);

        $instance->isSecure = true;

        return $instance;
    }

    /**
     * @param HttpRequest $request
     * @return ApiRequest
     */
    public static function createFromLaravelRequest(HttpRequest $request): ApiRequest
    {
        $apiRequest = new self;
        $apiRequest->httpMethod = Str::upper($request->getMethod());
        $apiRequest->payloadFormat = $request->getContent();
        $apiRequest->host = $request->getHost();
        $apiRequest->path = $request->path();
        $apiRequest->url = $request->url();
        $apiRequest->port = (string) $request->getPort();
        $apiRequest->isSecure = $request->isSecure();
        $apiRequest->clientIp = $request->getClientIp();
        $apiRequest->clientIps = $request->getClientIps();
        $apiRequest->setHeadersFromLaravelRequest($request);

        return  $apiRequest;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setHeadersFromGuzzleRequest(Request $request): static
    {
        $this->headers = [];

        foreach ($request->getHeaders() as $key => $value) {
            $this->headers[$key] = is_array($value) ? implode(',', $value) : $value;
        }

        return $this;
    }

    /**
     * @param HttpRequest $request
     * @return $this
     */
    public function setHeadersFromLaravelRequest(HttpRequest $request): static
    {
        $this->headers = [];

        foreach ($request->headers as $key => $value) {
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
