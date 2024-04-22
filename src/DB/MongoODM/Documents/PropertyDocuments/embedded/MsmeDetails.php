<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class MsmeDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $businessName;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $urn;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $registrationDate;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge([
            'businessName' => $this->businessName,
            'urn' => $this->urn,
            'registrationDate' => $this->registrationDate->toDateString(),
        ]);
    }
}
