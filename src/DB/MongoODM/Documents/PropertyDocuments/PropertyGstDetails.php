<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments;

use Delta4op\MongoODM\Facades\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Contracts\PropertyDocumentContract;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyGstDetailsRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="propertyGstDetails",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyGstDetailsRepository::class
 * )
 */
class PropertyGstDetails extends PropertyDocumentDetails
{
    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyGstDetails';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_GST = 'GST';
    public const TYPE_NO_GST = 'NO_GST';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $entityName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $gstNumber;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $state;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), arrayFilter([
            'entityName'    => $this->entityName,
            'gstNumber'     => $this->gstNumber,
            'state'         => $this->state,
        ]));
    }

    /**
     * User Repository
     *
     * @return PropertyGstDetailsRepository
     */
    public static function repository(): PropertyGstDetailsRepository
    {
        return DocumentManager::getRepository(self::class);
    }

    public function docType(): string
    {
        return "GST";
    }

    public function docTypeLabel(): string
    {
        return "GST Details";
    }
}
