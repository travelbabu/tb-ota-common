<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\OtaSubscriber;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\OtaSubscriberRepository;

/**
 * @ODM\Document(
 *     collection="otaSubscribers",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\OtaSubscriberRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class OtaSubscriber extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'otaSubscribers';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $email;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_SUBSCRIBED = 'SUBSCRIBED';
    public const STATUS_UNSUBSCRIBED = 'UNSUBSCRIBED';

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'    => $this->id,
            'email' => $this->email,
            'status'  => $this->status,
            'createdAt'  => $this->createdAt,
            'updatedAt'  => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return OtaSubscriberRepository
     */
    public static function repository(): OtaSubscriberRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
