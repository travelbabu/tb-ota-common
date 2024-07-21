<?php

namespace SYSOTEL\OTA\Common\Services\Resavenue\Api\ApiCalls;

use App\DB\Models\ApiLog\ApiLog;
use App\DB\Models\ApiLog\embedded\ApiRequest;
use App\Enums\ApiFormat;
use App\Enums\ApiLogStatus;
use App\Enums\ApiLogType;
use App\Enums\ApiProtocol;
use App\Enums\ApiRequestDirection;
use App\Enums\ChannelId;
use App\Services\ApiServices\ApiCall;
use SYSOTEL\OTA\Common\Services\Resavenue\Api\ResavenueApi;
use SYSOTEL\OTA\Common\Services\Resavenue\Api\ResavenueApiResponse;
use GuzzleHttp\Psr7\Request;

abstract class ResavenueApiCall extends ApiCall
{
    protected ResavenueApi $api;

    /**
     * @param ResavenueApi $api
     */
    public function __construct(ResavenueApi $api)
    {
        $this->api = $api;
    }

    /**
     * @param ApiLogType $type
     * @param Request $request
     * @return ApiLog
     */
    protected function createInitialApiLog(ApiLogType $type, Request $request): ApiLog
    {
        $apiLog = new ApiLog;
        $apiLog->channelId = ChannelId::RESAVENUE;
        $apiLog->type = $type;
        $apiLog->protocol = ApiProtocol::REST;
        $apiLog->format = ApiFormat::JSON;
        $apiLog->direction = ApiRequestDirection::OUTGOING;
        $apiLog->status = ApiLogStatus::PENDING;

        $apiRequest = ApiRequest::createFromGuzzleRequest($request);
        $apiLog->request()->associate($apiRequest);

        $apiLog->markAsStarted();

        $apiLog->save();

        return $apiLog;
    }

    /**
     * @param Request $request
     * @return ResavenueApiResponse
     */
    protected function makeApiCall(Request $request): ResavenueApiResponse
    {
        return (new ResavenueApiResponse($request))->execute();
    }

    /**
     * @param ApiLog $apiLog
     * @param ResavenueApiResponse $responseContext
     * @return ApiLog
     */
    protected function updateApiLogFromResponse(ApiLog $apiLog, ResavenueApiResponse $responseContext): ApiLog
    {
        $apiLog->status = $responseContext->getApiLogStatus();

        if ($apiLogError = $responseContext->getApiLogError()) {
            $apiLog->error()->associate($apiLogError);
        }

        if ($apiResponse = $responseContext->getApiResponse()) {
            $apiLog->response()->associate($apiResponse);
        }

        $apiLog->markAsCompleted();
        $apiLog->save();

        return $apiLog;
    }


}
