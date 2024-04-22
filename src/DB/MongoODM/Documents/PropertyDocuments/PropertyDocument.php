<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\DocumentManager;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\DocumentFile;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyDocumentRepository;
use SYSOTEL\OTA\Common\Enums\PropertyDocumentType;

/**
 * @ODM\Document(
 *     collection="propertyDocuments",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyDocumentRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({
 *     "AADHAAR":SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\types\AadhaarDocument::class,
 *     "PAN":SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\types\PanDocument::class,
 * })
 */
abstract class PropertyDocument extends Document
{
    use HasTimestamps;

    public abstract function getType(): PropertyDocumentType;

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
     * @var ArrayCollection<DocumentFile>
     * @ODM\EmbedMany (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\DocumentFile::class)
     */
    public $documents;

    /**
     * @var Verification
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification::class)
     */
    public $verification;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([

        ]);
    }

    /**
     * @return PropertyDocumentRepository
     */
    public static function repository(): PropertyDocumentRepository
    {
        /** @var PropertyDocumentRepository */
        return DocumentManager::getRepository(self::class);
    }
}
