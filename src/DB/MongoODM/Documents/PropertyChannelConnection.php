<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyChannelConnectionsRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="propertyChannelConnections",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyChannelConnectionsRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyChannelConnection extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyChannelConnections';

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
     * @var string
     * @ODM\Field(type="string")
     */
    public $baseChannelID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $connectedChannelID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_DISABLED = 'DISABLED';
    public const STATUS_VERIFICATION_PENDING = 'VERIFICATION_PENDING';

    /**
     * @ODM\PrePersist
     */
    public function onPrePersist()
    {
        if(!isset($this->createdAt)){
            $this->createdAt = now();
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'                  => $this->id,
            'propertyID'          => $this->propertyID,
            'baseChannelID'       => $this->baseChannelID,
            'connectedChannelID'  => $this->connectedChannelID,
            'status'              => $this->status,
            'createdAt'           => $this->createdAt,
            'updatedAt'           => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyChannelConnectionsRepository
     */
    public static function repository(): PropertyChannelConnectionsRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
