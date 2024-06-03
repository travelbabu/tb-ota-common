<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog\ApiLog;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyInventory\PropertyInventory;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyRate\PropertyRate;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class PropertyRateReference extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Id
     */
    public $_id;

    /**
     * @param PropertyRate $rate
     * @return static
     */
    public static function createFromPropertyInventory(PropertyRate $rate): static
    {
        $ref = new self();
        $ref->_id = $rate->id;

        return $ref;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->_id
        ]);
    }
}
