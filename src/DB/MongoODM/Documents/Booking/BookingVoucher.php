<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class BookingVoucher extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $guestVoucherFilePath;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $propertyVoucherFilePath;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'guestVoucherFilePath' => $this->guestVoucherFilePath,
            'propertyVoucherFilePath' => $this->propertyVoucherFilePath,
        ];
    }
}
