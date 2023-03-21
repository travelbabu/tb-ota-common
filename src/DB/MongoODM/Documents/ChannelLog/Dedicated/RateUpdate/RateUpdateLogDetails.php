<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\RateUpdate;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Arr;
use MongoDB\BSON\ObjectId;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class RateUpdateLogDetails extends EmbeddedDocument
{
    /**
     * @var ArrayCollection
     * @ODM\EmbedMany(targetDocument=UpdateDetails::class)
     */
    public $updates;

    /**
     * @var ObjectId[]
     * @ODM\Field(type="collection")
     */
    public $rateIDs;

    /**
     * @var ArrayCollection
     * @ODM\EmbedMany (targetDocument= SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\ChannelLogApiCall::class)
     */
    public $apiCalls;

    public function __construct(array $attributes = [])
    {
        $this->updates = new ArrayCollection();
        $this->rateIDs = [];

        parent::__construct($attributes);
    }

    /**
     * @param ObjectId|string|string[]|ObjectId[] $ids
     */
    public function addRateIDs(ObjectId|string|array $ids): static
    {
        foreach(Arr::wrap($ids) as $id) {

            $id = is_string($id) ? new ObjectId($id) : $id;

            $this->rateIDs[] = $id;
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
            'rateIDs' => $this->rateIDs,
        ]);
    }
}
