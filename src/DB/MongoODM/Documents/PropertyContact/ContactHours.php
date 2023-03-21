<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyContact;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PersonName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ContactHours extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field
     */
    public $from;

    /**
     * @var string
     * @ODM\Field
     */
    public $to;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'from' => $this->from,
            'to' => $this->to,
        ]);
    }
}
