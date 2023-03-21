<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Amenity;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AmenityRepository;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="amenities",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AmenityRepository::class
 * )
 */
class Amenity extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'amenities';

    /**
     * @var string
     * @ODM\Id(strategy="none",type="string")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $parentID;

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
    public $name;

    /**
     * @var ArrayCollection
     * @ODM\EmbedMany (targetDocument=ValueMeta::class)
     */
    public $meta;

    /**
     * @var SupplierDetails
     * @ODM\EmbedOne(targetDocument=SupplierDetails::class)
     */
    public $supplierDetails;

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
     * @var int
     * @ODM\Field(type="int")
     */
    public $featureOrder;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'               => $this->id,
            'parentID'         => $this->parentID,
            'category'         => $this->category,
            'name'             => $this->name,
            'meta'             => $this->meta->toArray(),
            'supplierDetails'  => toArrayOrNull($this->supplierDetails),
            'sortOrder'        => $this->sortOrder,
            'isFeatured'     => $this->isFeatured,
            'featureOrder'     => $this->featureOrder,
            'createdAt'        => $this->createdAt,
            'updatedAt'        => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return AmenityRepository
     */
    public static function repository(): AmenityRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
