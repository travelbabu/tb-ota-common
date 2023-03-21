<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyContact;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasDeletedAt;
use Delta4op\MongoODM\Traits\HasTimestamps;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Email;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PersonName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyContactRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="propertyContacts",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyContactRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyContact extends Document
{
    use HasTimestamps, HasDefaultAttributes, HasDeletedAt;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyContacts';

    /**
     * @var ObjectId
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
    public $type;
    public const TYPE_GENERAL_INQUIRY = 'INQUIRY';
    public const TYPE_RESERVATION = 'RESERVATION';
    public const TYPE_ACCOUNTS = 'ACCOUNTS';
    public const TYPE_INVENTORY = 'INVENTORY';

    /**
     * @var PersonName
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PersonName::class)
     */
    public $name;

    /**
     * @var ArrayCollection & Email[]
     * @ODM\EmbedMany (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Email::class)
     */
    public $emails;

    /**
     * @var ArrayCollection & Mobile[]
     * @ODM\EmbedMany (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Mobile::class)
     */
    public $contactNumbers;

    /**
     * @var ContactHours
     * @ODM\EmbedOne (targetDocument=ContactHours::class)
     */
    public $contactHours;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $languages;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isPublicContact;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $printOnVoucher;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $notifications;
    public const NOTIFICATION_BOOKING = 'BOOKING';
    public const NOTIFICATION_INQUIRY = 'INQUIRY';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_DISBLAED = 'DISABLED';
    public const STATUS_DELETED = 'DELETED';


    public $defaults = [
        'isPublicContact' => false,
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->emails = new ArrayCollection;
        $this->contactNumbers = new ArrayCollection;

        parent::__construct($attributes);
    }

    public function emailString(): string
    {
        return implode(', ', collect($this->emails)->pluck('id')->toArray());
    }

    public function contactNumberString(): string
    {
        return implode(', ', collect($this->contactNumbers)->pluck('number')->toArray());
    }

    public function markAsDeleted()
    {
        $this->status = self::STATUS_DELETED;
        $this->deletedAt = now();
        return $this;
    }

    /**
     * @return array
     */
    public function emailArray(): array
    {
        $emails = [];
        foreach($this->emails as $email) {
            $emails[] = $email->id;
        }

        return array_unique($emails);
    }

    /**
     * @return array
     */
    public function mobileNumberArray(): array
    {
        $numbers = [];
        foreach($this->contactNumbers as $contactNumber) {
            $numbers[] = $contactNumber->stringValue();
        }

        return array_unique($numbers);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'propertyID' => $this->propertyID,
            'type' => $this->type,
            'name' => toArrayOrNull($this->name),
            'contactHours' => toArrayOrNull($this->contactHours),
            'languages' => $this->languages,
            'emails' => collect($this->emails)->toArray(),
            'contactNumbers' => collect($this->contactNumbers)->toArray(),
            'isPublicContact' => $this->isPublicContact,
            'printOnVoucher' => $this->printOnVoucher,
            'notifications' => $this->notifications,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'deletedAt' => $this->deletedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyContactRepository
     */
    public static function repository(): PropertyContactRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
