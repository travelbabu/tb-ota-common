<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyRateLinkage;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\documentManager;

/**
 * @ODM\Document( collection="propertyRateLinkages")
 */
class PropertyRateLinkage extends Document
{
    use HasRepository;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyRateLinkages';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var Carbon
     * @ODM\EmbedOne (targetDocument="carbon")
     */
    public $productRateMappings;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'                => $this->id,
            'propertyID'       => $this->propertyID,
            'createdAt'         => $this->createdAt,
        ]);
    }
}
