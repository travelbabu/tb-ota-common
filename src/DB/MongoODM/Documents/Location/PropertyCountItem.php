<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyCountItem extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $count;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'type'  => $this->type,
            'count' => $this->count,
        ]);
    }
}
