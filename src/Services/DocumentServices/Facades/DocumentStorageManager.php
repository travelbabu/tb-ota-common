<?php

namespace SYSOTEL\OTA\Common\Services\DocumentServices\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\VendorApiLogBaseClass;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;

/**
 * @method static PropertyImage store(int|Property $property, UploadedFile $imageFile, string $documentType)
 * @method static string fileURL(string|PropertyDocument $path)
 * @method static StreamedResponse fileDownloadResponse(string|PropertyDocument $document)
 * @method static StreamedResponse fileResponse(string|PropertyDocument $document)
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
