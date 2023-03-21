<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM;

use Delta4op\MongoODM\Documents\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasTimestamps;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PermissionRepository;

/**
 * @ODM\Document(
 *     collection="permissions",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PermissionRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class Permission extends Document
{
    use CanResolveStringID, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'permissions';

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
    public $name;

    /**
     * @var PermissionBlock
     */
    public $permissionBlock;

    /**
     * @ODM\PostLoad
    */
    public function setPermissionBlock()
    {
        $this->permissionBlock = new PermissionBlock($this);
    }

    /**
     * @param string|Permission $permission
     * @return bool
     */
    public function matches(string|self $permission): bool
    {
        return $this->permissionBlock->matches(self::resolveID($permission));
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'         => $this->id,
            'name'       => $this->name,
            'parentID'   => $this->parentID,
            'createdAt'  => $this->createdAt,
            'updatedAt'  => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PermissionRepository
     */
    public static function repository(): PermissionRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
