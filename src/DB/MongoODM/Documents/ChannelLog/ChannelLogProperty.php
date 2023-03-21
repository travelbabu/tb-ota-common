<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ChannelLogProperty extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $connectedID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $connectedName;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'   => $this->id,
            'name' => $this->name,
            'connectedID'   => $this->connectedID,
            'connectedName'   => $this->connectedName,
        ]);
    }
}
