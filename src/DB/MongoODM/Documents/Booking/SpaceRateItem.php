<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class SpaceRateItem extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_BASE_CHARGES = 'BASE_CHARGES';
    public const TYPE_EXTRA_ADULT_CHARGES = 'EXTRA_ADULT_CHARGES';
    public const TYPE_EXTRA_CHILD_CHARGES = 'EXTRA_CHILD_CHARGES';

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $charges;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'type'   => $this->type,
            'charges'    => $this->charges,
        ];
    }
}
