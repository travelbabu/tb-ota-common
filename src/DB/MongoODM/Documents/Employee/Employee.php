<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Employee;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\EmployeeRepository;

/**
 * @ODM\Document(
 *     collection="employees",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\EmployeeRepository::class
 * ),
 * @ODM\HasLifecycleCallbacks
 */
class Employee extends Document
{
    use HasTimestamps, CanResolveIntegerID, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'employees';

    /**
     * @var int
     * @ODM\Id(strategy="CUSTOM", type="int", options={"class"=SYSOTEL\OTA\Common\DB\MongoODM\StorageStrategies\AutoIncrementID::class }))
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
    public $type;
    public const TYPE_SALES = 'SALES';
    public const TYPE_SUPPORT = 'SUPPORT';
    public const TYPE_BD = 'BD';
    public const TYPE_MANAGEMENT = 'MANAGEMENT';
    public const TYPE_OTHER = 'OTHER';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';

    /**
     * @var ?UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $creator;

    protected $defaults = [
        'status' => self::STATUS_ACTIVE
    ];

    public function readableID(): string
    {
        return "EMP-" . $this->id;
    }

    /**
     * @return EmployeeRepository
     */
    public static function repository(): EmployeeRepository
    {
        return DocumentManager::getRepository(self::class);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'creator' => $this->creator?->toArray(),
            'status' => $this->status,
        ];
    }
}
