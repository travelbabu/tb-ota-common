<?php

namespace SYSOTEL\OTA\Common\Services\StorageServices\Facades;

/**
 * @see \SYSOTEL\OTA\Common\Services\StorageServices\PropertyPublicStorage
 */
class PropertyPublicStorage extends StorageManager
{
    protected static function getFacadeAccessor(): string
    {
        return 'PublicStorageManagers';
    }
}
