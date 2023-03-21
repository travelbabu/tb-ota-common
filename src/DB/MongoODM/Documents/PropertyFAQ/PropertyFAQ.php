<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyFAQ;

use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasDeletedAt;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Illuminate\Support\Carbon;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyFAQRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="propertyFAQs",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyFAQRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyFAQ extends EmbeddedDocument
{
    use HasTimestamps, HasDeletedAt, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyFAQs';

    /**
     * @var ObjectId
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var string
     * @ODM\Field(type="string", name="q")
     */
    public $question;

    /**
     * @var string
     * @ODM\Field(type="string", name="a")
     */
    public $answer;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_DISABLED = 'DISABLED';
    public const STATUS_DELETED = 'DELETED';


    public $defaults = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'       => $this->id,
            'propertyID' => $this->propertyID,
            'question' => $this->question,
            'answer'   => $this->answer,
            'status'   => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'deletedAt' => $this->deletedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyFAQRepository
     */
    public static function repository(): PropertyFAQRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
