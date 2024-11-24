<?php

namespace SYSOTEL\OTA\Common\Services\StorageServices\Facades;

use Illuminate\Http\UploadedFile;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\FileV2;

/**
 * @method static FileV2 storePaymentAttachment(UploadedFile $uploadedFile, int $propertyId, int $bookingId, string $paymentId)
 *
 * @see \SYSOTEL\OTA\Common\Services\StorageServices\PropertyBookingStorage
 */
class PropertyBookingStorage extends PropertyPrivateStorage
{
    protected static function getFacadeAccessor(): string
    {
        return 'PropertyBookingStorage';
    }
}
