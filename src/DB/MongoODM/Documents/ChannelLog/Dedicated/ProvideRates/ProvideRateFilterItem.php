<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\ProvideRates;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class ProvideRateFilterItem extends EmbeddedDocument
{
    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $from;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $till;

    /**
     * @var ArrayCollection<ProvideRateFilterSpaceItem>
     * @ODM\EmbedMany(targetDocument=ProvideRateFilterSpaceItem::class)
     */
    public $spaces;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->spaces = new ArrayCollection;

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
