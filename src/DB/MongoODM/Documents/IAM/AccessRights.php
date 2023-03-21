<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM;

use Delta4op\MongoODM\Documents\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasTimestamps;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AccessRightsRepository;

/**
 * @ODM\Document(
 *     collection="accessRights",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AccessRightsRepository::class
 * )
 */
class AccessRights extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'accessRights';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $userID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $role;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $permissions;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $policies;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'           => $this->id,
            'userID'       => $this->userID,
            'propertyID'   => $this->propertyID,
            'role'         => $this->role,
            'permissions'  => $this->permissions,
            'policies'     => $this->policies,
            'createdAt'    => $this->createdAt,
            'updatedAt'    => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return AccessRightsRepository
     */
    public static function repository(): AccessRightsRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
