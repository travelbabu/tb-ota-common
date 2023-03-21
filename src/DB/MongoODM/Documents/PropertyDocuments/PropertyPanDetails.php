<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments;

use Delta4op\MongoODM\Facades\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyPanDetailsRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="propertyPanDetails",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyPanDetailsRepository::class
 * )
 */
class PropertyPanDetails extends PropertyDocumentDetails
{
    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyPanDetails';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $pan;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), arrayFilter([
            'name' => $this->name,
            'pan' => $this->pan,
        ]));
    }

    /**
     * User Repository
     *
     * @return PropertyPanDetailsRepository
     */
    public static function repository(): PropertyPanDetailsRepository
    {
        return DocumentManager::getRepository(self::class);
    }

    public function docType(): string
    {
        return 'PAN';
    }

    public function docTypeLabel(): string
    {
        return 'PAN Details';
    }
}
