<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelConnectivityRepository;

/**
 * @ODM\Document(
 *     collection="channelConnectivity",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelConnectivityRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("channelID")
 * @ODM\DiscriminatorMap({
 *     "RESAVENUE":SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity\types\ResAvenue\ResAvenueConnectivity::class,
 *    
 * })
 */
abstract class ChannelConnectivity extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'channelConnectivity';

    /**
     * @var string
     * @ODM\Id(strategy="none",type="string")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var string
     * @ODM\Field(type="boolean")
     */
    public $isExpired;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'  => $this->id,
        ]);
    }

    public abstract function getChannelID(): string;

    /**
     * User Repository
     *
     * @return ChannelConnectivityRepository
     */
    public static function repository(): ChannelConnectivityRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
