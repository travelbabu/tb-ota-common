<?php

namespace SYSOTEL\OTA\Common\Services\Resavenue\Api;

use App\Services\ApiServices\ApiResponseContext;

class ResavenueApiResponse extends ApiResponseContext
{
    /**
     * @return string|null
     */
    public function getErrorMessageFromResponse(): ?string
    {
        $responseArray = $this->getJsonArrayResponse();
        if (is_array($responseArray)) {
            $firstArrayKey = array_key_first($responseArray);

            if ($firstArrayKey) {
                return $responseArray[$firstArrayKey]['Error'] ?? null;
            }
        }

        return null;
    }
}
