<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\embedded\Rating;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\embedded\Review;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyReviewRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="propertySpaces",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyReviewRepository::class
 * ),
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
     * @inheritdoc
     */
    protected string $keyType = 'int';

    /**
     * @var int
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $bookingID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $propertyName;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $guestID;

    /**
     * @var ?Review
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\embedded\Review::class)
     */
    public $review;

    /**
     * @var ?Rating
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\embedded\Rating::class)
     */
    public $rating;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $reviewedAt;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'                  => $this->id,
            'createdAt'           => $this->createdAt,
            'updatedAt'           => $this->updatedAt,
        ]);
    }

    /**
     * @return PropertyReviewRepository
     */
    public static function repository(): PropertyReviewRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
