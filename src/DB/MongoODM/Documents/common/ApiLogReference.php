<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class ApiLogReference extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Id
     */
    public $_id;

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
