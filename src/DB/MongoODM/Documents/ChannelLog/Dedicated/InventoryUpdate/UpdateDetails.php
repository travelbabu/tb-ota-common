<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\InventoryUpdate;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class UpdateDetails extends EmbeddedDocument
{
    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $startDate;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $endDate;

    /**
     * @ODM\DiscriminatorField("attributeType")
     * @ODM\EmbedOne(
     *   discriminatorMap={
     *     "STANDARD"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated\StandardSpaceAttributes::class,
     *   },
     * )
     */
    public $attributes;


    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'attributes' => $this->attributes->toArray()
        ]);
    }
}