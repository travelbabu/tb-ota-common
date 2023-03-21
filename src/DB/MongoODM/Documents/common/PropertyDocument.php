<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\Services\DocumentServices\Facades\DocumentStorageManager;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyDocument extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $filePath;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $sizeInKb;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $extension;
    public const FORMAT_PNG = 'png';
    public const FORMAT_JPG = 'jpg';
    public const FORMAT_JPEG = 'jpeg';
    public const FORMAT_PDF = 'pdf';
    public const FORMAT_WEBP = 'webp';

    /**
     * @return string
     */
    public function url(): string
    {
        return DocumentStorageManager::fileURL($this->filePath);
    }

    /**
     * @return StreamedResponse
     */
    public function fileResponse(): StreamedResponse
    {
        return DocumentStorageManager::fileResponse($this);
    }

    /**
     * @return StreamedResponse
     */
    public function fileDownloadResponse(): StreamedResponse
    {
        return DocumentStorageManager::fileDownloadResponse($this);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'filePath'     => $this->filePath,
            'url'     => $this->url(),
            'sizeInKb' => $this->sizeInKb,
            'extension'       => $this->extension,
        ]);
    }
}
