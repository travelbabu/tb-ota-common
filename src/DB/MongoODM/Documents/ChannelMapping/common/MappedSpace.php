<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\common;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelProperty\ChannelSpace;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class MappedSpace extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $externalSpaceID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $externalSpaceName;

    /**
     * @var string[]
     * @ODM\Field(type="collection")
     */
    public $mappedAttributes;

    /**
     * @param ChannelSpace $channelSpace
     * @return MappedSpace
     */
    public static function createFromChannelSpace(ChannelSpace $channelSpace): MappedSpace
    {
        return new self([
            'externalSpaceID' => $channelSpace->id,
            'externalSpaceName' => $channelSpace->name,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'externalSpaceID'   => $this->externalSpaceID,
            'externalSpaceName' => $this->externalSpaceName,
            'mappedAttributes'  => $this->mappedAttributes,
        ]);
    }
}
