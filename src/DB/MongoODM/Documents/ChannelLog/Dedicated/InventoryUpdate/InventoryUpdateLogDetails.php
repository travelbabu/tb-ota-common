<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\InventoryUpdate;

use Delta4op\MongoODM\Traits\HasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyRestrictionsReference;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyInventoryReference;

/**
 * @ODM\EmbeddedDocument
 */
class InventoryUpdateLogDetails extends EmbeddedDocument
{
    use HasRepository;

    /**
     * @var ArrayCollection & InventoryUpdateItem[]
     * @ODM\EmbedMany(targetDocument=InventoryUpdateItem::class)
     */
    public $inventoryUpdates;

    /**
     * @var ArrayCollection & PropertyInventoryReference[]
     * @ODM\EmbedMany(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyInventoryReference::class)
     */
    public $inventoryRefs;

    /**
     * @var ArrayCollection & PropertyRestrictionsReference[]
     * @ODM\EmbedMany(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyRestrictionsReference::class)
     */
    public $restrictionsRefs;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->inventoryUpdates = new ArrayCollection;
        $this->inventoryRefs = new ArrayCollection;
        $this->restrictionsRefs = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'inventoryUpdates' => collect($this->inventoryUpdates)->toArray(),
            'inventoryRefs' => collect($this->inventoryRefs)->toArray(),
        ]);
    }
}
