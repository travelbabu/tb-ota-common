<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog\ApiLog;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyInventory\PropertyInventory;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class PropertyInventoryReference extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Id
     */
    public $_id;

    /**
     * @param PropertyInventory $inventory
     * @return PropertyInventoryReference
     */
    public static function createFromPropertyInventory(PropertyInventory $inventory): PropertyInventoryReference
    {
        $ref = new self();
        $ref->_id = $inventory->id;

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
