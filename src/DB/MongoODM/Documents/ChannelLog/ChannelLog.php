<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Traits\Macroable;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelLogRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="channelLogs",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelLogRepository::class
 * )
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({
 *     "PROVIDE_PROPERTY_CONTENT":Dedicated\ProvidePropertyContent\ProvidePropertyContentLog::class,
 * })
 * @ODM\HasLifecycleCallbacks
 */
abstract class ChannelLog extends Document
{
    use Macroable, HasTimestamps;

    public abstract function getType(): string;

    /**
     * @inheritdoc
     */
    protected string $collection = 'channelLogs';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var ?ChannelLogProperty
     * @ODM\EmbedOne(targetDocument=ChannelLogProperty::class)
     */
    public $property;

    /**
     * @var ?ChannelLogAttemptDetails
     * @ODM\EmbedOne(targetDocument=ChannelLogAttemptDetails::class)
     */
    public $attemptDetails;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);
    }

    /**
     * @return ChannelLogRepository
     */
    public static function repository(): ChannelLogRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
