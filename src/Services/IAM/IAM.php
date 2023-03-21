<?php

namespace SYSOTEL\OTA\Common\Services\IAM;

use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM\AccessRights;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM\Permission;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use function collect;

class IAM
{
    public function can(string $requestPermission, int|User $user, int|Property $property = null): bool
    {
        $can = false;
        $permissions = $this->getPermissions($user, $property);
        foreach($permissions as $assignedPermission) {
            if($assignedPermission->matches($requestPermission)) {
                $can = true;
                break;
            }
        }

        return $can;
    }

    /**
     * @param array $requestPermissions
     * @param int|User $user
     * @param int|Property|null $property
     * @return bool
     */
    public function canAny(array $requestPermissions, int|User $user, int|Property $property = null): bool
    {
        $permissions = $this->getPermissions($user, $property);
        
        $can = false;
        foreach($requestPermissions as $requestPermission) {
           if($this->can($requestPermission, $user, $property)) {
               $can = true;
               break;
           }
        }

        return $can;
    }

    /**
     * @param array $requestPermissions
     * @param int|User $user
     * @param int|Property|null $property
     * @return bool
     */
    public function canAll(array $requestPermissions, int|User $user, int|Property $property = null): bool
    {
        $permissions = $this->getPermissions($user, $property);

        $can = true;
        foreach($requestPermissions as $requestPermission) {
            if(!$this->can($requestPermission, $user, $property)) {
                $can = false;
                break;
            }
        }

        return $can;
    }

    /**
     * @param int|User $user
     * @param int|Property|null $property
     * @return Collection
     */
    public function getPermissions(int|User $user, int|Property $property = null): Collection
    {
        $permissionIDs = [];

        if($userAccessRights = AccessRights::repository()->findUserRights($user)) {
            $permissionIDs = array_merge($permissionIDs, $userAccessRights->permissions);
        }

        if($property && $propertyAccessRights = AccessRights::repository()->findUserPropertyRights($user, $property)) {
            $permissionIDs = array_merge($permissionIDs, $propertyAccessRights->permissions);
        }

        $permissions = Permission::repository()->findBy([
            '_id' => ['$in' => $permissionIDs]
        ]);

        return collect($permissions);
    }
}