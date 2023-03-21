<?php

namespace SYSOTEL\OTA\Common\Services\AgentDocumentServices\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount\AgentAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\File;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;

/**
 * @method static File store(int|AgentAccount $account, UploadedFile $file, string $documentType)
 * @method static string fileURL(string|File $path)
 * @method static StreamedResponse fileDownloadResponse(string|File $document)
 * @method static StreamedResponse fileResponse(string|File $document)
 * @method static Storage storage()
 *
 * @see \SYSOTEL\OTA\Common\Services\AgentDocumentServices\AgentAccountStorageManager
 */
class AgentAccountStorageManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'AgentAccountStorageManager';
    }
}
