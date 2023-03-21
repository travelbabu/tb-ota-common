<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\VendorApiLog;

use Delta4op\MongoODM\Facades\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyBankDetailsRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="val_tgrBookingCancellation"
 * )
 */
class TgrBookingCancellationApiLog extends VendorApiLogBaseClass
{
    /**
     * @inheritdoc
     */
    protected string $collection = 'val_tgrBookingCancellation';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_INITIATE = 'INITIATE';
    public const TYPE_CANCEL = 'CANCEL';

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $bookingGlobalID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $internalBookingID;

    /**
     * @var int
     * @ODM\Field(type="string")
     */
    public $externalBookingID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $internalPropertyID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $externalPropertyID;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), arrayFilter([
            'bookingGlobalID' => $this->bookingGlobalID,
            'bookingID' => $this->bookingID,
            'externalBookingID' => $this->externalBookingID,
            'internalPropertyID' => $this->internalPropertyID,
            'externalPropertyID' => $this->externalPropertyID,
        ]));
    }

    /**
     * User Repository
     *
     * @return PropertyBankDetailsRepository
     */
    public static function repository(): PropertyBankDetailsRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
