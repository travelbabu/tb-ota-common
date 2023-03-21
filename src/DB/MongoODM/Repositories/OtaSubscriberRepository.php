<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\OtaSubscriber\OtaSubscriber;

class OtaSubscriberRepository extends DocumentRepository
{
    /**
     * @param string $email
     * @return OtaSubscriber|null
     */
    public function findByEmail(string $email): ?OtaSubscriber
    {
        $criteria = [
            'email' => $email,
        ];

        return $this->findOneBy($criteria);
    }

    /**
     * @return Collection
     */
    public function getAllSubscribers(): Collection
    {
        $criteria = ['status' => OtaSubscriber::STATUS_SUBSCRIBED,];
        $orderBy = ['createdAt' => -1];

        return $this->getCollectionBy($criteria, $orderBy);
    }

    /**
     * @return Collection
     */
    public function getAllUnsubscribers(): Collection
    {
        $criteria = ['status' => OtaSubscriber::STATUS_UNSUBSCRIBED,];
        $orderBy = ['createdAt' => -1];

        return $this->getCollectionBy($criteria, $orderBy);
    }

}
