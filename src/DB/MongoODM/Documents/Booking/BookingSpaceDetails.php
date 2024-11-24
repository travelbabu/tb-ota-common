<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class BookingSpaceDetails extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $totalCount;

    /**
     * @var ?bool
     * @ODM\Field(type="bool")
     */
    public $hasMultipleSpaces;

    /**
     * @var ?bool
     * @ODM\Field(type="bool")
     */
    public $hasMultipleSpaceTypes;

    /**
     * @var ArrayCollection<BookingSpace>
     * @ODM\EmbedMany(targetDocument=BookingSpace::class)
     */
    public $spaces;

    /**
     * @param BookingSpace $space
     * @return $this
     */
    public function addSpace(BookingSpace $space): static
    {
        $this->spaces->add($space);
        $this->calculate();
        return $this;
    }

    /**
     * @return static
     */
    public function calculate(): static
    {
        $this->totalCount = $this->spaces->count();
        $this->hasMultipleSpaces = $this->spaces->count() > 1;
        $this->hasMultipleSpaceTypes = false;

        $spaceId = null;
        foreach($this->spaces as $space) {
            if(!$spaceId) {
                $spaceId = $space->spaceID;
                continue;
            }

            if($spaceId !== $space->spaceID) {
                $this->hasMultipleSpaceTypes = true;
                break;
            }
        }

        return $this;
    }

    /**
     * @param int $spaceNo
     * @return BookingSpace|null
     */
    public function getSpaceForSpaceNo(int $spaceNo): ?BookingSpace
    {
        foreach ($this->spaces as $space) {
            if ($space->spaceNo === $spaceNo) {
                return $space;
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
            'totalCount' => $this->totalCount,
            'hasMultipleSpaces' => $this->hasMultipleSpaces,
            'hasMultipleSpaceTypes' => $this->hasMultipleSpaceTypes,
            'spaces' => collect($this->spaces)->toArray(),
        ];
    }
}
