<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\RateUpdate;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardProductAttributes;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class RateUpdateItem extends EmbeddedDocument
{
    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $start;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $end;

    /**
     * @var ?StandardProductAttributes
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardProductAttributes::class)
     */
    public $rateAttributes;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'startDate' => $this->start,
            'endDate' => $this->end,
            'attributes' => $this->rateAttributes->toArray()
        ]);
    }
}