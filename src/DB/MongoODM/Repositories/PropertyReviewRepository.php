<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\Booking;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\PropertyReview;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Guest\Guest;
use SYSOTEL\OTA\Common\Enums\PropertyReviewStatus;

class PropertyReviewRepository extends DocumentRepository
{
    /**
     * @param string $id
     * @return PropertyReview|null
     * @throws LockException
     * @throws MappingException
     */
    public function findById(string $id): ?PropertyReview
    {
        return $this->find($id);
    }

    /**
     * @param int $propertyId
     * @return PropertyReview[]
     */
    public function getActivePropertyReviews(int $propertyId): array
    {
        return $this->findBy([
            'propertyID' => $propertyId,
            'status' => PropertyReviewStatus::ACTIVE->value
        ], ['reviewedAt', -1]);
    }

    /**
     * @param int $propertyId
     * @return PropertyReview[]
     */
    public function getAllPropertyReviews(int $propertyId): array
    {
        return $this->findBy([
            'propertyID' => $propertyId,
        ], ['reviewedAt', -1]);
    }

    /**
     * @param int|Guest $guest
     * @return PropertyReview[]
     */
    public function getByGuest(int|Guest $guest): array
    {
        $guestId = Guest::resolveID($guest);

        return $this->findBy([
            'guestID' => $guestId,
        ], ['reviewedAt', -1]);
    }

    /**
     * @param int|Booking $booking
     * @return PropertyReview[]
     */
    public function getByBooking(int|Booking $booking): array
    {
        $bookingId = Guest::resolveID($booking);

        return $this->findBy([
            'bookingID' => $bookingId,
        ], ['reviewedAt', -1]);
    }

    /**
     * @param int|Guest $guest
     * @param int|Booking $booking
     * @return PropertyReview|null
     */
    public function getByBookingIdAndGuestId(int|Guest $guest, int|Booking $booking): ?PropertyReview
    {
        $guestId = Guest::resolveID($guest);
        $bookingId = Guest::resolveID($booking);

        return $this->findOneBy([
            'guestID' => $guestId,
            'bookingID' => $bookingId,
        ]);
    }
}
