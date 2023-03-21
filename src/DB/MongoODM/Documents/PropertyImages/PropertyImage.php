<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Traits\Macroable;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyImageRepository;
use SYSOTEL\OTA\Common\Services\ImageServices\Facades\ImageStorageManager;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="propertyImages",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyImageRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyImage extends Document
{
    use Macroable, HasTimestamps, HasDefaultAttributes;

    public const RATIO_SQUARE = 'square';
    public const RATIO_STANDARD = 'standard';

    public const SIZE_SM = 'sm';
    public const SIZE_MD = 'md';
    public const SIZE_LG = 'lg';

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyImages';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID = Supplier::ID_SELF;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $spaceID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $category;
    public const CATEGORY_PROPERTY = 'PROPERTY';
    public const CATEGORY_SPACE = 'SPACE';

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
     * @ODM\Field (type="string")
     */
    public $filePath;

    /**
     * @var ImageMetadata
     * @ODM\EmbedOne (targetDocument=ImageMetadata::class)
     */
    public $metadata;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $sortOrder;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isFeatured;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_DELETED = 'DELETED';

    /**
     * @var Verification
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification::class)
     */
    public $verification;

    /**
     * @var TgrDetails
     * @ODM\EmbedOne(targetDocument=TgrDetails::class)
     */
    public $tgrDetails;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $deletedAt;

    public $defaults = [
        'isFeatured' => false,
        'supplierID' => Supplier::ID_SELF,
    ];

    /**
     * @return $this
     */
    public function markAsDeleted(): static
    {
        $this->status = self::STATUS_DELETED;
        $this->deletedAt = now();
        return $this;
    }

    /**
     * @param string $ratio
     * @param string $size
     * @return string
     */
    public function url(string $ratio = PropertyImage::RATIO_STANDARD, string $size = PropertyImage::SIZE_MD): string
    {
        return ImageStorageManager::imageURL($this->filePath, $ratio, $size);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'  => $this->id,
            'propertyID'      => $this->propertyID,
            'spaceID'         => $this->spaceID,
            'title'           => $this->title,
            'description'     => $this->description,
            'filePath'        => $this->filePath,
            'url'             => $this->url(),
            'category'        => $this->category,
            'metadata'        => toArrayOrNull($this->metadata),
            'verification'    => toArrayOrNull($this->verification),
            'tgrDetails'          => toArrayOrNull($this->tgrDetails),
            'isFeatured'      => $this->isFeatured,
            'status'          => $this->status,
            'sortOrder'       => $this->sortOrder,
            'createdAt'       => $this->createdAt,
            'updatedAt'       => $this->updatedAt,
            'deletedAt'       => $this->deletedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyImageRepository
     */
    public static function repository(): PropertyImageRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
