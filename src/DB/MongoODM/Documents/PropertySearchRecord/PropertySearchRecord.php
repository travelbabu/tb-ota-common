<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySearchRecord;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertySearchRecordRepository;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="propertySearchRecords",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertySearchRecordRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertySearchRecord extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertySearchRecords';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var SearchCauser
     * @ODM\EmbedOne(targetDocument=SearchCauser::class)
     */
    public $causer;

    /**
     * @var SearchConfig
     * @ODM\EmbedOne(targetDocument=SearchConfig::class)
     */
    public $config;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $queryArray;

    /**
     * @var SuitableFilters
     * @ODM\EmbedOne(targetDocument=SuitableFilters::class)
     */
    public $suitableFilters;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $potentialMatchCount;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $chunkSize;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $pointer;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $currentPage;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $matchCount;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $searchCompleted;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'         => $this->id,
            'config'     => toArrayOrNull($this->config),
            'suitableFilters'     => toArrayOrNull($this->suitableFilters),
            'causer'     => toArrayOrNull($this->causer),
            'pointer'    => $this->pointer,
            'createdAt'  => $this->createdAt,
            'updatedAt'  => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertySearchRecordRepository
     */
    public static function repository(): PropertySearchRecordRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
