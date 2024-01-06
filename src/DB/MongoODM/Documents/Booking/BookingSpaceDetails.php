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
     * @var ArrayCollection & BookingSpace[]
     * @ODM\EmbedMany(targetDocument=BookingSpace::class)
     */
    public $spaces;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->spaces = new ArrayCollection;

        parent::__construct($attributes);
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
