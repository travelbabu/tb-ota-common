<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Illuminate\Support\Str;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class DateRange extends EmbeddedDocument
{
    /**
     * @var Carbon
     * @ODM\field(type="carbon")
     */
    public $startDate;

    /**
     * @var Carbon
     * @ODM\field(type="carbon")
     */
    public $endDate;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }
}
