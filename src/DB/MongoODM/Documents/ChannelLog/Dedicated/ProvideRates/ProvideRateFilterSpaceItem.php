<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\ProvideRates;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class ProvideRateFilterSpaceItem extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $_id;

    /**
     * @var ArrayCollection<ProvideRateFilterProductItem>
     * @ODM\EmbedMany(targetDocument=ProvideRateFilterProductItem::class)
     */
    public $products;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->products = new ArrayCollection;

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
