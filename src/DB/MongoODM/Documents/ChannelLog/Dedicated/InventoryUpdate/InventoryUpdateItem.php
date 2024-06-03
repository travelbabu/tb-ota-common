<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\InventoryUpdate;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardSpaceAttributes;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class InventoryUpdateItem extends EmbeddedDocument
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
     * @var ?StandardSpaceAttributes
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardSpaceAttributes::class)
     */
    public $inventoryAttributes;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'startDate' => $this->start,
            'endDate' => $this->end,
            'attributes' => $this->inventoryAttributes->toArray()
        ]);
    }
}