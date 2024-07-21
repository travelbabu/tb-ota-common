<?php

namespace SYSOTEL\OTA\Common\Services\Resavenue\Api\ApiCalls;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog\ApiLog;
use SYSOTEL\OTA\Common\Services\Resavenue\Api\ResavenueApi;
use Exception;
use GuzzleHttp\Psr7\Request;

class PushBooking extends ResavenueApiCall
{
    private string $payload;

    /**
     * @param ResavenueApi $api
     * @param string $payload
     */
    public function __construct(ResavenueApi $api, string $payload)
    {
        parent::__construct($api);
        $this->payload = $payload;
    }

    /**
     * @throws Exception
     */
    public function execute(): ApiLog
    {
        # create request
        $request = new Request(
            method: 'POST',
            uri: $this->api->getBookingPushUrl(),
            headers: ['Content-Type' => 'application/json'],
            body: $this->payload
        );

        # create api log
        $apiLog = $this->createInitialApiLog(ApiLogType::RESAVENUE_PUSH_BOOKINGS, $request);

        # make api call
        $responseContext = $this->makeApiCall($request);

        # update api log from response
        $apiLog = $this->updateApiLogFromResponse($apiLog, $responseContext);


        return $apiLog;

    }
}
