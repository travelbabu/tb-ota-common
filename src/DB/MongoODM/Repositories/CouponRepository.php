<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

class CouponRepository extends DocumentRepository
{
    public function getActiveCommonCoupons(): Collection
    {
        return $this->getCollectionBy([
            'userID' => ['$exists' => false],
            'isActive' => true
        ]);
    }

    public function getUserTaggedCoupons(int|User $user): Collection
    {
        return $this->getCollectionBy([
            'userID' => User::resolveID($user),
            'isActive' => true
        ]);
    }

    public function getAllActiveForUser(int|User $user): Collection
    {
        $userID = User::resolveID($user);

        $commonCoupons = $this->findBy([
            'userID' => ['$exists' => false],
            'isActive' => true
        ]);

        $userCoupons = [];

        if($userID) {
            $userCoupons = $this->findBy([
                'userID' => $userID,
                'isActive' => true
            ]);
        }

        return collect(array_merge($commonCoupons, $userCoupons));
    }
}
