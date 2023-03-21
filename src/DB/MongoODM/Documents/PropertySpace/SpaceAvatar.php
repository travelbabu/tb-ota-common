<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\Services\ImageServices\Facades\ImageStorageManager;

/**
 * @ODM\EmbeddedDocument
 */
class SpaceAvatar extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID = Supplier::ID_SELF;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $filePath;

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
        return [
            'filePath' => $this->filePath,
            'supplierID' => $this->supplierID,
            'url' => $this->url(),
        ];
    }
}
