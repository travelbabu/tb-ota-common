<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class PanDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $pan;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $dob;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge([
            'pan' => $this->pan,
            'name' => $this->name,
            'dob' => $this->dob,
        ]);
    }
}
