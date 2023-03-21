<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ActivityTypeRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="activityTypes",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ActivityTypeRepository::class
 * )
 */
class ActivityType extends Document
{
    use CanResolveStringID, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'activityTypes';

    public const INVENTORY_UPDATE = 'INVENTORY_UPDATE';
    public const RATE_UPDATE = 'RATE_UPDATE';

    /**
     * @var string
     * @ODM\Id(strategy="none", type="string")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $parentID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $operationType;
    public const OPERATION_TYPE_CREATE = "CREATE";
    public const OPERATION_TYPE_UPDATE = "UPDATE";
    public const OPERATION_TYPE_DELETE = "DELETE";
    public const OPERATION_TYPE_OTHER = "OTHER";

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $description;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'            => $this->id,
            'parentID'      => $this->parentID,
            'name'          => $this->name,
            'operationType' => $this->operationType,
            'description'   => $this->description,
            'createdAt'     => $this->createdAt,
            'udpatedAt'     => $this->udpatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return ActivityTypeRepository
     */
    public static function repository(): ActivityTypeRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
