<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\ProvidePropertyContent;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class ProvidePropertyContentLogDetails extends EmbeddedDocument
{
    public function toArray(): array
    {
        return [];
    }
}
