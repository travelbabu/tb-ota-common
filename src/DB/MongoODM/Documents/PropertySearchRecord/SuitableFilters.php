<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySearchRecord;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class SuitableFilters extends EmbeddedDocument
{
    /**
     * @var ArrayCollection & PopularDestination[]
     * @ODM\EmbedMany(targetDocument=PopularDestination::class)
     */
    public $popularDestinations;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->popularDestinations = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'popularDestinations' => collect($this->popularDestinations)->toArray(),
        ]);
    }
}
