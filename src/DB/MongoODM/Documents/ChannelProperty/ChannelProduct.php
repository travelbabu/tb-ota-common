<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Delta4op\MongoODM\Facades\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelPropertyRepository;

/**
 * @ODM\EmbeddedDocument
 */
class ChannelProduct extends EmbeddedDocument
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
     * @var carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;

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
            'createdAt' => $this->createdAt,
        ]);
    }
}

