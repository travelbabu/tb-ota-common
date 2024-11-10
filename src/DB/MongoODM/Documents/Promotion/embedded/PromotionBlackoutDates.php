<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\embedded;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PromotionBlackoutDates extends EmbeddedDocument
{
    /**
     * @var ArrayCollection & BlackoutDateRange[]
     * @ODM\EmbedMany (targetDocument=BlackoutDateRange::class)
     */
    public $ranges;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->ranges = new ArrayCollection;

        parent::__construct($attributes);
    }


    /**
     * @param Carbon $date
     * @return bool
     */
    public function matchFound(Carbon $date): bool
    {
        foreach ($this->ranges as $dateRange) {
            if ($dateRange->matchFound($date)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
