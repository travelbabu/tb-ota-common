<?php

namespace SYSOTEL\OTA\Common\Services\Resavenue\Api;

use App\DB\Models\ApiLog\ApiLog;
use SYSOTEL\OTA\Common\Services\Resavenue\Api\ApiCalls\PushBooking;

class ResavenueApi
{
    protected string $userName;
    protected string $password;
    protected string $idContext;
    protected string $apiKey;
    protected string $bookingPushUrl;

    public function __construct()
    {
        $config = config('channel-connectivity.resavenue');
        $this->userName = $config['userName'];
        $this->password = $config['password'];
        $this->apiKey = $config['api_auth']['api_key'];
        $this->idContext = $config['id_context'];
        $this->bookingPushUrl = $config['booking_push_url'];

    }

    /**
     *
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getIdContext(): string
    {
        return $this->idContext;
    }


    /**
     * @return string
     */
    public function getBookingPushUrl(): string
    {
        return $this->bookingPushUrl;
    }


    /**
     * @param array $headers
     * @return array
     */
    public function createHeaders(array $headers = []): array
    {
        return array_merge([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ], $headers);
    }

    public function pushBooking(string $payload): ApiLog
    {
        return (new PushBooking($this, $payload))->execute();
    }

}
