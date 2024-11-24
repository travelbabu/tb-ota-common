<?php

namespace SYSOTEL\OTA\Common\Services\StorageServices\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\FileV2;

/**
 * @method static FileV2 store(UploadedFile $uploadFile, string $path, string $fileName)
 * @method static string fileURL(string|FileV2 $path)
 * @method static StreamedResponse fileDownloadResponse(string|FileV2 $document)
 * @method static StreamedResponse fileResponse(string|FileV2 $document)
 * @method static Storage storage()
 *
 * @see \SYSOTEL\OTA\Common\Services\StorageServices\StorageManager
 */
abstract class StorageManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'StorageManager';
    }
}
