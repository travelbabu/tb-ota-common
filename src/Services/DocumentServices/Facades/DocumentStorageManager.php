<?php

namespace SYSOTEL\OTA\Common\Services\DocumentServices\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\DocumentFile;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;
use SYSOTEL\OTA\Common\Enums\PropertyDocumentType;

/**
 * @method static PropertyImage store(int|Property $property, UploadedFile|UploadedFile[] $files, PropertyDocumentType $documentType)
 * @method static string fileURL(string|DocumentFile $path)
 * @method static StreamedResponse fileDownloadResponse(string|DocumentFile $document)
 * @method static StreamedResponse fileResponse(string|DocumentFile $document)
 * @method static Storage storage()
 *
 * @see \SYSOTEL\OTA\Common\Services\DocumentServices\AgentAccountStorageManager
 */
class DocumentStorageManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'DocumentStorageManager';
    }
}
