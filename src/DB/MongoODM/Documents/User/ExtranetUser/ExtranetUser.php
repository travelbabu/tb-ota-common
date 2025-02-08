<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\ExtranetUser;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class ExtranetUser extends User
{
    public $type = self::TYPE_EXTRANET_USER;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $propertyName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $propertyLocation;

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