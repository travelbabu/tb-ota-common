<?php

namespace SYSOTEL\OTA\Common\Services\IAM\Facades;

use Illuminate\Support\Facades\Facade;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

/**
 * @method static IAM can(string $requestPermission, int|User $user, int|Property $property = null)
 * @method static IAM canAny(array $requestPermissions, int|User $user, int|Property $property = null)
 * @method static IAM canAll(array $requestPermissions, int|User $user, int|Property $property = null)
 *
 * @see IAM
*/
class IAM extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'IAM';
    }
}
