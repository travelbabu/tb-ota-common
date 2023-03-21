<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\InventoryUpdate;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Delta4op\MongoODM\Traits\HasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Arr;
use MongoDB\BSON\ObjectId;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class InventoryUpdateLogDetails extends EmbeddedDocument
{
    use HasRepository;

    /**
     * @var ArrayCollection
     * @ODM\EmbedMany(targetDocument=UpdateDetails::class)
     */
    public $updates;

    /**
     * @var ObjectId[]
     * @ODM\Field(type="collection")
     */
    public $inventoryIDs;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $source;
    public const SOURCE_APP_INLINE_UPDATE = 'SYSOTEL_APP_INLINE_UPDATE';

    public function __construct(array $attributes = [])
    {
        $this->updates = new ArrayCollection();
        $this->inventoryIDs = [];

        parent::__construct($attributes);
    }

    /**
     * @param ObjectId|string|string[]|ObjectId[] $ids
     */
    public function addInventoryLogIDs(ObjectId|string|array $ids): static
    {
        foreach(Arr::wrap($ids) as $id) {

            $id = is_string($id) ? new ObjectId($id) : $id;

            $this->inventoryIDs[] = $id;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'updates' => collect($this->updates)->toArray(),
            'source' => $this->source,
            'inventoryIDs' => $this->inventoryIDs,
        ]);
    }
}
