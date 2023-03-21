<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelPropertyRepository;

/**
 * @ODM\Document(
 *     collection="channelProperties",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelPropertyRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class ChannelProperty extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'channelProperties';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @ODM\ReferenceOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelApiLog\ChannelApiLog::class)
     */
    public $apiLogID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $channelID;

    /**
     * @var string
     * @ODM\Field(type="int")
     */
    public $internalPropertyID;

    /**
     * @var ChannelPropertyDetails
     * @ODM\EmbedOne (targetDocument=ChannelPropertyDetails::class)
     */
    public $externalProperty;

    /**
     * @var ArrayCollection
     * @ODM\EmbedMany(targetDocument=ChannelSpace::class)
     */
    public $spaces;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;

    public function __construct(array $attributes = [])
    {
        $this->spaces = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @param $id
     * @return ChannelSpace|null
     */
    public function getSpace($id): ?ChannelSpace
    {
        return collect($this->spaces)->firstWhere('id', $id);
    }

    /**
     * @param $id
     * @return ChannelProduct|null
     */
    public function getProduct($id): ?ChannelProduct
    {
        foreach($this->spaces as $space) {
            $product = collect($space->products)->firstWhere('id', $id);
            if($product) {
                return $product;
            }
        }

        return null;
    }

    /**
     * @param string|ChannelProduct $channelProduct
     * @return ChannelSpace|null
     */
    public function getSpaceForProduct(string|ChannelProduct $channelProduct): ?ChannelSpace
    {
        $channelProductID = $channelProduct instanceof ChannelProduct ? $channelProduct->id : $channelProduct;

        /** @var ChannelSpace $space */
        foreach($this->spaces as $space) {
            $channelProduct = collect($space->products)->firstWhere('id', $channelProductID);
            if($channelProduct) {
                return $space;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'apiLogID' => $this->apiLogID,
            'channelID' => $this->channelID,
            'spaces' => $this->spaces->toArray(),
            'internalPropertyID' => $this->internalPropertyID,
            'externalProperty' => $this->externalProperty->toArray(),
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);
    }

    /**
     * @return ChannelPropertyRepository
     */
    public static function repository(): ChannelPropertyRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}

