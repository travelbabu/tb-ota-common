<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;

/**
 * @ODM\EmbeddedDocument
 */
class SettlementProperty extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $_id;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $displayName;

    public static function createFromBooking(Property $property): SettlementProperty {
        $propertyRef = new self;
        $propertyRef->_id = $property->id;
        $propertyRef->displayName = $property->displayName;

        return $propertyRef;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [];
    }
}
