<?php

namespace SYSOTEL\OTA\Common\Services\OtaContractServices\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 *
 * @see \SYSOTEL\OTA\Common\Services\DocumentServices\AgentAccountStorageManager
 */
class OtaContractStorageManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'OtaContractStorageManager';
    }
}
