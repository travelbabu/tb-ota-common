<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Delta4op\MongoODM\Facades\DocumentManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Exception;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelPropertyRepository;

/**
 * @ODM\EmbeddedDocument
 */
class ChannelSpace extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $baseOccupancy;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $maxOccupancy;

    /**
     * @var carbon
     * @ODM\Field(type="carbon")
     */
    public $validFrom;

    /**
     * @var carbon
     * @ODM\Field(type="carbon")
     */
    public $validTo;

    /**
     * @var ArrayCollection
     * @ODM\EmbedMany(targetDocument=ChannelProduct::class)
     */
    public $products;

    /**
     * @var carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;

    /**
     * @throws Exception
     */
    public function __construct(array $attributes = [])
    {
        $this->products = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'validFrom' => $this->validFrom,
            'validTo' => $this->validTo,
            'baseOccupancy' => $this->baseOccupancy,
            'maxOccupancy' => $this->maxOccupancy,
            'products' => $this->products->toArray(),
            'createdAt' => $this->createdAt,
        ]);
    }
}

