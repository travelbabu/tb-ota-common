<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Inquiry;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Traits\Macroable;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\InquiryRepository;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="inquiries",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\InquiryRepository::class
 * )
 */
class Inquiry extends Document
{
    use Macroable, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'inquiries';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $causer;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_GENERAL = 'GENERAL';
    public const TYPE_B2B = 'B2B';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $source;
    public const SOURCE_CONTACT_US = 'CONTACT_US';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $title;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $description;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_OPEN = 'OPEN';
    public const STATUS_CLOSED = 'CLOSED';

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isSpam;

    /**
     * @var ArrayCollection
     * @ODM\EmbedMany (targetDocument=InquiryEvent::class)
    */
    public $events;

    public function __construct(array $attributes = [])
    {
        $this->events = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'userID'      => $this->userID,
            'causer'      => toArrayOrNull($this->causer),
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'type'        => $this->type,
            'source'      => $this->source,
            'isSpam'      => $this->isSpam,
            'events'      => $this->events,
            'createdAt'   => $this->createdAt,
            'updatedAt'   => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return InquiryRepository
     */
    public static function repository(): InquiryRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
