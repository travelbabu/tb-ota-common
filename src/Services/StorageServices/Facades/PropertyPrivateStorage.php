<?php

namespace SYSOTEL\OTA\Common\Services\StorageServices\Facades;

/**
 * @see \SYSOTEL\OTA\Common\Services\StorageServices\PropertyPublicStorage
 */
class PropertyPrivateStorage extends StorageManager
{
    protected static function getFacadeAccessor(): string
    {
        return 'PrivateStorageManagers';
    }
}
