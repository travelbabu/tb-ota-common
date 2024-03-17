<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class BookingGuestDetails extends EmbeddedDocument
{
    /**
     * @var GuestCount
     * @ODM\EmbedOne(targetDocument=GuestCount::class)
     */
    public $guestCount;

    /**
     * @var ArrayCollection & GuestProfile[]
     * @ODM\EmbedMany(targetDocument=GuestProfile::class)
     */
    public $profiles;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->profiles = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @return ?GuestProfile
     */
    public function getPrimaryGuestProfile(): ?GuestProfile
    {
        foreach($this->profiles as $profile) {
            if($profile->isPrimary) {
                return $profile;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'guestCount' => toArrayOrNull($this->guestCount),
            'profile' => collect($this->profiles)->toArray(),
        ];
    }
}
