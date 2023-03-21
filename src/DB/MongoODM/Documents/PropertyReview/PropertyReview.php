<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyReview;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Traits\Macroable;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyReviewsRepository;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="propertyReviews",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyReviewsRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyReview extends Document
{
    use HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyReviews';

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
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID;

    /**
     * @var Reviewer
     * @ODM\EmbedOne (targetDocument=Reviewer::class)
     */
    public $reviewer;

    /**
     * @var Comment
     * @ODM\EmbedOne (targetDocument=Comment::class)
     */
    public $comment;

    /**
     * @var Rating
     * @ODM\EmbedOne (targetDocument=Rating::class)
     */
    public $rating;

    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $postedAt;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    protected $defaults = [
        'supplierID' => Supplier::ID_SELF
    ];

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'                => $this->id,
            'supplierID'       => $this->supplierID,
            'propertyID'            => $this->propertyID,
            'reviewer'           => toArrayOrNull($this->reviewer),
            'comment'           => toArrayOrNull($this->comment),
            'rating'           => toArrayOrNull($this->rating),

            'status'         => $this->status,
            'psotedAt'         => $this->createdAt,
            'createdAt'         => $this->createdAt,
            'updatedAt'         => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyReviewsRepository
     */
    public static function repository(): PropertyReviewsRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}