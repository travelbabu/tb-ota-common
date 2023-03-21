<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyContact\PropertyContact;

class PropertyContactRepository extends DocumentRepository
{
    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection
     */
    public function getAllForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge([
            'propertyID' => Property::resolveID($property)
        ], $criteria);

        $sort = array_merge([
            'createdAt' => -1
        ], $sort);

        return $this->getCollectionBy($criteria, $sort);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection
     */
    public function getActiveContactsForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge([
            'status' => PropertyContact::STATUS_ACTIVE
        ], $criteria);

        return $this->getAllForProperty($property, $criteria, $sort);
    }

    /**
     * @param int|Property $property
     * @param array $criteria
     * @param array $sort
     * @return Collection
     */
    public function getAllAvailableForProperty(int|Property $property, array $criteria = [], array $sort = []): Collection
    {
        $criteria = array_merge([
            'deletedAt' => ['$exists' => false]
        ], $criteria);

        return $this->getAllForProperty($property, $criteria, $sort);
    }

    public function getActiveBookingSubscribers(int|Property $property): Collection
    {
        return $this->getActiveContactsForProperty($property, [
            'notifications' => PropertyContact::NOTIFICATION_BOOKING
        ]);
    }

    public function getActiveVoucherFriendlyContacts(int|Property $property): Collection
    {
        return $this->getActiveContactsForProperty($property, [
            'printOnVoucher' => true
        ]);
    }

    public function getActiveBookingSubscriberEmails(int|Property $property): array
    {
        $contacts = $this->getActiveBookingSubscribers($property);

        $emails = [];
        foreach($contacts as $contact) {
            $emails = array_merge($emails, $contact->emailArray());
        }

        return array_unique($emails);
    }
}
