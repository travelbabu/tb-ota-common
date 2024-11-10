<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\embedded;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class BlackoutDateRange extends EmbeddedDocument
{
    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $fromDate;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $toDate;

    /**
     * @param Carbon $date
     * @return bool
     */
    public function matchFound(Carbon $date): bool
    {
        return $this->fromDate->between($this->fromDate, $this->toDate);
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
