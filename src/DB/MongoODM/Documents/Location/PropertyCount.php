<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyCount extends EmbeddedDocument
{
    /**
     * @var ArrayCollection & PropertyCountItem
     * @ODM\EmbedMany (targetDocument=PropertyCountItem::class)
     */
    public $items;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $count;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->items = new ArrayCollection;
        $this->count = 0;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'type' => collect($this->items)->toArray(),
            'count'    => $this->count,
        ]);
    }
}
