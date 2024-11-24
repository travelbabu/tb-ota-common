<?php

namespace SYSOTEL\OTA\Common\Services\StorageServices;

class PropertyPublicStorage extends StorageManager
{
    public function isPublicVisibility(): bool
    {
        return true;
    }
}
