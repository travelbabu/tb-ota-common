<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class DocumentFile extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="object_id")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $filePath;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $byteSize;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $extension;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'filePath' => $this->filePath,
            'byteSize' => $this->byteSize,
            'extension' => $this->extension,
        ]);
    }
}
