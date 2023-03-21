<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCancellationPolicy;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\Services\ImageServices\Facades\ImageStorageManager;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class CancellationRule extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $startInterval;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $endInterval;

    /**
     * @var CancellationPenalty
     * @ODM\EmbedOne (targetDocument=CancellationPenalty::class)
     */
    public $penalty;

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->penalty->value .
            '% penalty if cancelled between ' .
            $this->startInterval / 24 .
            ' days to ' .
            $this->endInterval / 24 .
            ' days before checkin date';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'penalty' => toArrayOrNull($this->penalty)
        ]);
    }
}
