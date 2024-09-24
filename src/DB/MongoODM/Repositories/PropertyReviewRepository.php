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
     * @param int $propertyID
     * @return PropertyReview[]
     */
    public function getActivePropertyReviews(int $propertyID): array
    {
        return $this->findBy([
            'propertyID' => $propertyID,
            'status' => PropertyReviewStatus::ACTIVE->value
        ], ['reviewedAt' => -1]);
    }

    /**
     * @param int $propertyID
     * @return PropertyReview[]
     */
    public function getAllPropertyReviews(int $propertyID): array
    {
        return $this->findBy([
            'propertyID' => $propertyID,
        ], ['reviewedAt' => -1]);
    }

    /**
     * @param int|Guest $guest
     * @return PropertyReview[]
     */
    public function getByGuest(int|Guest $guest): array
    {
        $guestID = Guest::resolveID($guest);

        return $this->findBy([
            'guestID' => $guestID,
        ], ['reviewedAt' => -1]);
    }

    /**
     * @param int|Booking $booking
     * @return PropertyReview[]
     */
    public function getByBooking(int|Booking $booking): array
    {
        $bookingID = Guest::resolveID($booking);

        return $this->findBy([
            'bookingID' => $bookingID,
        ], ['reviewedAt' => -1]);
    }

    /**
     * @param int|Guest $guest
     * @param int|Booking $booking
     * @return PropertyReview|null
     */
    public function getByBookingIdAndGuestId(int|Guest $guest, int|Booking $booking): ?PropertyReview
    {
        $guestID = Guest::resolveID($guest);
        $bookingID = Booking::resolveID($booking);

        return $this->findOneBy([
            'guestID' => $guestID,
            'bookingID' => $bookingID,
        ]);
    }
}
