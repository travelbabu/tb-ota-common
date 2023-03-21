<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyOtaContract;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class OtaCommission extends EmbeddedDocument
{
    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $value;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'value' => $this->value
        ]);
    }
}
