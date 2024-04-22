<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class AadhaarDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $aadhaarNumber;

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
            'aadhaarNumber' => $this->aadhaarNumber,
            'name' => $this->name,
            'dob' => $this->dob,
        ]);
    }
}
