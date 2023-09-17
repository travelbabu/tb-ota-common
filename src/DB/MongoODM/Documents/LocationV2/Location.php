<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\PropertyCount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\common\LocationReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\LocationRepository;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="locations",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\LocationRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class Location extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'locations';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field
     */
    public $type;
    public const TYPE_REGION = 'REGION';
    public const TYPE_COUNTRY = 'COUNTRY';
    public const TYPE_STATE = 'STATE';
    public const TYPE_CITY = 'CITY';
    public const TYPE_AREA = 'AREA';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field
     */
    public $slug;

    /**
     * @var GeoLocation
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation::class)
     */
    public $geoLocation;

    /**
     * @var LocationReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\common\LocationReference::class)
     */
    public $region;

    /**
     * @var LocationReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\common\LocationReference::class)
     */
    public $country;

    /**
     * @var LocationReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\common\LocationReference::class)
     */
    public $state;

    /**
     * @var LocationReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\common\LocationReference::class)
     */
    public $city;

    /**
     * @var LocationReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\common\LocationReference::class)
     */
    public $area;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $searchKeywords;

    /**
     * @var PropertyCount
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\LocationV2\common\PropertyCount::class)
     */
    public $propertyCount;

    public function __construct(array $attributes = [])
    {
        $this->searchKeywords = [];
        $this->propertyCount = new PropertyCount;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'              => $this->id,
            'slug'            => $this->slug,
            'name'            => $this->name,
            'status'          => $this->status,
            'geoLocation'     => toArrayOrNull($this->geoLocation),
            'searchKeywords'  => $this->searchKeywords,
            'propertyCount'  => toArrayOrNull($this->propertyCount),
        ]);
    }

    public static function repository(): LocationRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
