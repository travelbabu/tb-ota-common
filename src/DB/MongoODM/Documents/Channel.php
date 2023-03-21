<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Traits\Macroable;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelRepository;

/**
 * @ODM\Document(
 *     collection="channels",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelRepository::class
 * )
 */
class Channel extends Document
{
    use Macroable, CanResolveStringID, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'channels';

    /**
     * @var string
     * @ODM\Id(strategy="none", type="string")
     */
    public $id;
    public const ID_INTERNAL_B2C = 'INTERNAL_B2C';
    public const ID_INTERNAL_B2B = 'INTERNAL_B2B';
    public const ID_INTERNAL_CORPORATE = 'INTERNAL_CORP';
    public const ID_GOOGLE_HOTEL_CENTER = 'GOOGLE_HOTEL_CENTER';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $displayName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $vendor;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_OTA = 'OTA';
    public const TYPE_BOOKING_ENGINE = 'BOOKING_ENGINE';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $segment;
    public const SEGMENT_B2C = 'B2C';
    public const SEGMENT_B2B = 'B2B';
    public const SEGMENT_CORPORATE = 'CORPORATE';

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isInternal;

    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $apiPayloadFormat;
    public const API_FORMAT_JSON = 'JSON';
    public const API_FORMAT_XML = 'XML';

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'                => $this->id,
            'displayName'       => $this->displayName,
            'vendor'            => $this->vendor,
            'segment'           => $this->segment,
            'status'            => $this->status,
            'type'              => $this->type,
            'isInternal'        => $this->isInternal,
            'apiPayloadFormat'  => $this->apiPayloadFormat,
            'createdAt'         => $this->createdAt,
            'updatedAt'         => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return ChannelRepository
     */
    public static function repository(): ChannelRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
