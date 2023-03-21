<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class Admin extends User
{
    public $type = 'ADMIN';

    /**
     * @var string
     * @ODM\Field(type="string")
     *
     */
    public $adminRole;
    public const ADMIN_ROLE_SUPER_ADMIN = 'SUPER_ADMIN';
    public const ADMIN_ROLE_ADMIN = 'ADMIN';

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter(
            array_merge(parent::toArray(),[

            ])
        );
    }
}