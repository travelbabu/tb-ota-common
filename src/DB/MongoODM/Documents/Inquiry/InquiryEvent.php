<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Inquiry;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Traits\Macroable;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\InquiryEventRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\InquiryRepository;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class InquiryEvent extends EmbeddedDocument
{
    use HasTimestamps;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $causer;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $note;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_OPEN = 'OPEN';
    public const STATUS_CLOSED = 'CLOSED';

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'causer' => toArrayOrNull($this->causer),
            'note' => $this->note,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);
    }
}
