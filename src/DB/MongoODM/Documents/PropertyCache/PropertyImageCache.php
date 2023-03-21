<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCache;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\Services\ImageServices\Facades\ImageStorageManager;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyImageCache extends EmbeddedDocument
{
    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $category;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    public $filePath;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    public $title;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    public $description;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isFeatured;

    /**
     * @param string $ratio
     * @param string $size
     * @return string
     */
    public function url(string $ratio = PropertyImage::RATIO_STANDARD, string $size = PropertyImage::SIZE_MD): string
    {
        return (new PropertyImage([
            'filePath' => $this->filePath,
            'supplierID' => $this->supplierID
        ]))->url($ratio, $size);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'          => $this->id,
            'supplierID'  => $this->supplierID,
            'category'    => $this->category,
            'filePath'    => $this->filePath,
            'title'       => $this->title,
            'description' => $this->description,
            'isFeatured' => $this->isFeatured,
        ]);
    }
}
