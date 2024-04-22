<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class GstDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $gstNumber;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $entityName;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $state;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge([
            'gstNumber' => $this->gstNumber,
            'entityName' => $this->entityName,
            'state' => $this->state,
        ]);
    }
}
