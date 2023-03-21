<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\AdminSetting;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AdminSettingRepository;

/**
 * @ODM\Document(
 *     collection="adminSettings",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AdminSettingRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class AdminSetting extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'adminSettings';

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
     * @var string
     * @ODM\Field(type="string")
     */
    public $value;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isArray;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $dataType;
    public const DATA_TYPE_INT = 'int';
    public const DATA_TYPE_DOUBLE = 'double';
    public const DATA_TYPE_STRING = 'string';
    public const DATA_TYPE_OBJECT_ID = 'objectId';

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([

        ]);
    }

    /**
     * User Repository
     *
     * @return AdminSettingRepository
     */
    public static function repository(): AdminSettingRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
