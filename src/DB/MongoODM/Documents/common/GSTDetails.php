<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class GSTDetails extends EmbeddedDocument implements HasFileContract
{
    /**
     * @var File
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\File::class)
     */
    public $file;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $gstNumber;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $entityName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $state;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $docType;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'file'   => toArrayOrNull($this->file),
            'gstNumber'  => $this->gstNumber,
            'entityName' => $this->entityName,
            'state'      => $this->state,
        ]);
    }
}
