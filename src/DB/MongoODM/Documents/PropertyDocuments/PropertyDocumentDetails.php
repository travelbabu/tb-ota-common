<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Contracts\PropertyDocumentContract;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\MappedSuperclass
 * @ODM\HasLifecycleCallbacks
 */
abstract class PropertyDocumentDetails extends Document implements PropertyDocumentContract
{
    use HasTimestamps;

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var UserReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $causer;

    /**
     * @var PropertyDocument
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyDocument::class)
     */
    public $document;

    /**
     * @var Verification
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification::class)
     */
    public $verification;

    /**
     * @return string|null
     */
    public function documentURL(): ?string
    {
        return isset($this->document) ? $this->document->url : null;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'                => $this->id,
            'propertyID'        => $this->propertyID,
            'causer'            => toArrayOrNull($this->causer),
            'document'          => toArrayOrNull($this->document),
            'verification'      => toArrayOrNull($this->verification),
            'createdAt'         => $this->createdAt,
            'updatedAt'         => $this->updatedAt,
        ]);
    }
}
