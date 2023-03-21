<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount\AgentAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\Booking;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM\AccessRights;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

class BookingRepository extends DocumentRepository
{
    /**
     * @param int $bookingID
     * @param array $filters
     * @return Booking|null
     */
    public function findLatestByBookingID(int $bookingID, array $filters = []): ?Booking
    {
        $criteria = array_merge([
            'bookingID' => $bookingID
        ],$filters);

        $orderBy = ['version' => -1];

        return $this->findOneBy($criteria, $orderBy);
    }

    /**
     * @param int $bookingID
     * @return Booking|null
     */
    public function findLatestVersion(int $bookingID): ?Booking
    {
        return $this->findOneBy(['bookingID' => $bookingID], ['version' => -1]);
    }

    /**
     * @param AgentAccount|int $account
     * @param array $filters
     * @param array $criteria
     * @return Booking[]
     */
    public function findAllForAgentAccount(AgentAccount|int $account, array $filters = [], array $criteria = []): array
    {
        $filters = array_merge([
            'agentDetails.accountID' => AgentAccount::resolveID($account)
        ],$filters);

        $criteria = array_merge([
            'createdAt' => -1
        ], $criteria);

        return $this->findBy($filters, $criteria);
    }
}
