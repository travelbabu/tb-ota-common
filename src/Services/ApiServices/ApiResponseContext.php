<?php

namespace SYSOTEL\OTA\Common\Services\ApiServices;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use SimpleXMLElement;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog\ApiRequest;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog\ApiResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ErrorDetails;
use SYSOTEL\OTA\Common\Helpers\Enums;
use Throwable;

class ApiResponseContext
{
    protected Request $request;
    protected ?ResponseInterface $response = null;
    protected ?string $responseContent = null;
    protected ?Exception $exception = null;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return ApiResponseContext
     */
    public function execute(): static
    {
        try {
            # send request
            $response = (new Client())->send($this->request);

            # attach successful response
            $this->response = $response;

        } catch (Throwable $exception) {
            $this->exception = $exception;

            if ($exception instanceof BadResponseException) {
                $this->response = $exception->getResponse();
            }
        }

        if ($this->response) {

            $this->responseContent = $this->response->getBody()?->getContents();

            // response body return stream response
            // rewinding it so that it can be pointed
            // to start of file again
            $this->response->getBody()->rewind();
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getErrorMessageFromResponse(): ?string
    {
        return null;
    }

    /**
     * @return ApiRequest
     */
    public function getApiRequest(): ApiRequest
    {
        return ApiRequest::createFromGuzzleRequest($this->request);
    }

    /**
     * @return ApiResponse|null
     */
    public function getApiResponse(): ?ApiResponse
    {
        if(!$this->response) {
            return null;
        }

        $apiResponse = new ApiResponse;
        $apiResponse->httpStatusCode = $this->getResponse()->getStatusCode();
        $apiResponse->payload = $this->responseContent;
        $apiResponse->setHeadersFromResponse($this->getResponse());

        return $apiResponse;
    }

    /**
     * Get api log error
     *
     * @return ErrorDetails|null
     */
    public function getApiLogError(): ?ErrorDetails
    {
        $exception = $this->exception;
        $errorMessage = $this->getErrorMessageFromResponse();

        if (!$exception && !$errorMessage) {
            return null;
        }

        if ($exception) {
            $error = ErrorDetails::createFromThrowable($exception);

            if ($errorMessage) {
                $error->message = $errorMessage;
            }

            return $error;
        }

        $apiLogError = new ErrorDetails;
        $apiLogError->message = $errorMessage ?? '';
        return $apiLogError;
    }

    /**
     * @return string
     */
    public function getApiLogStatus(): string
    {
        return $this->hasError()
            ? Enums::API_LOG_STATUS_FAILED
            : Enums::API_LOG_STATUS_SUCCESS;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return bool
     */
    public function hasError(): bool
    {
        if (!$this->response) {
            return true;
        }

        // check for error message in the api response
        // regardless of the http status
        $errorMessage = $this->getErrorMessageFromResponse();

        if (is_string($errorMessage) && !empty($errorMessage)) {
            return true;
        }


        // if no error message is found then
        // check if http status code is successful or not
        return !$this->hasSuccessfulHttpStatus();
    }

    /**
     * @return ResponseInterface|null
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return string|null
     */
    public function getResponseContent(): ?string
    {
        return $this->responseContent;
    }

    /**
     * @return array|null
     */
    public function getJsonArrayResponse(): ?array
    {
        // || !isJson($this->responseContent)
        if (is_null($this->responseContent)) {
            return null;
        }

        $jsonArray = json_decode(
            mb_convert_encoding($this->responseContent, 'UTF-8', 'UTF-8'),
            true
        );

        if(is_array($jsonArray)) {
            return $jsonArray;
        }

        return null;
    }

    /**
     * @return ?SimpleXMLElement
     */
    public function getXmlResponse(): ?SimpleXMLElement
    {
        if (is_null($this->responseContent)) {
            return null;
        }

        libxml_use_internal_errors(true);
        $doc = simplexml_load_string($this->responseContent);

        if(!$doc) {
            return null;
        }

        return $doc;
    }



    /**
     * @return Exception|null
     */
    public function getException(): ?Exception
    {
        return $this->exception;
    }

    /**
     * @return bool
     */
    public function hasSuccessfulHttpStatus(): bool
    {
        $statusCode = $this->response?->getStatusCode();

        if(!is_numeric($statusCode)) {
            return false;
        }

        return $statusCode >= 200 && $statusCode < 300;
    }
}