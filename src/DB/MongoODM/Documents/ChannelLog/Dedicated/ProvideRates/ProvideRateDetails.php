<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\ProvideRates;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class ProvideRateDetails extends EmbeddedDocument
{
    /**
     * @var ProvideRateFilterItem
     * @ODM\EmbedMany(targetDocument=ProvideInventoryFilterItem::class)
     */
    public $filters;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->filters = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}
