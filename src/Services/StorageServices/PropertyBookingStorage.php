<?php

namespace SYSOTEL\OTA\Common\Services\StorageServices;

use Illuminate\Http\UploadedFile;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\FileV2;

class PropertyBookingStorage extends PropertyPrivateStorage
{
    /**
     * @param UploadedFile $uploadedFile
     * @param int $propertyId
     * @param int $bookingId
     * @param string $paymentId
     * @return FileV2
     */
    public function storePaymentAttachment(UploadedFile $uploadedFile, int $propertyId, int $bookingId, string $paymentId): FileV2
    {
        $path = "$propertyId/bookings/$bookingId/payments/$paymentId";
        $fileName = "bp_{$propertyId}_{$bookingId}_{$paymentId}." . $uploadedFile->extension();

        return $this->store(
            $uploadedFile,
            $path,
            $fileName
        );
    }
}
