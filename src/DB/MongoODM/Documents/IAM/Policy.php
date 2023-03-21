<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM;

use Delta4op\MongoODM\Documents\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasTimestamps;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AccessRightsRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PolicyRepository;

/**
 * @ODM\Document(
 *     collection="policies",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PolicyRepository::class
 * )
 */
class Policy extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'policies';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $permissions;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'           => $this->id,
            'name'         => $this->name,
            'permissions'  => $this->permissions,
            'createdAt'    => $this->createdAt,
            'updatedAt'    => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PolicyRepository
     */
    public static function repository(): PolicyRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
