<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\Services\AgentDocumentServices\Facades\AgentAccountStorageManager;
use SYSOTEL\OTA\Common\Services\DocumentServices\Facades\DocumentStorageManager;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class File extends EmbeddedDocument
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
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'filePath'     => $this->filePath,
            'sizeInKb' => $this->sizeInKb,
            'extension'       => $this->extension,
        ]);
    }
}
