<?php

namespace SYSOTEL\OTA\Common\Services\ImageServices\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;

/**
 * @method static PropertyImage storeImage(UploadedFile $imageFile)
 * @method static self useDocument(PropertyImage $document)
 * @method static string imageURL(string $path, string $ratio = PropertyImage::RATIO_STANDARD, string $size = PropertyImage::SIZE_MD)
 *
 * @see \SYSOTEL\OTA\Common\Services\ImageServices\ImageStorageManager
*/
class ImageStorageManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ImageStorageManager';
    }
}
