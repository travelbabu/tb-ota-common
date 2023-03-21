<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location;

use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CityReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CountryReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\StateReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AreaRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="geoAreas",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AreaRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class Area extends LocationItem
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'geoAreas';

    /**
     * @var CountryReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CountryReference::class)
     */
    public $country;

    /**
     * @var StateReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\StateReference::class)
     */
    public $state;

    /**
     * @var CityReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CityReference::class)
     */
    public $city;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), arrayFilter([
            'country'         => toArrayOrNull($this->country),
            'state'           => toArrayOrNull($this->state),
            'city'            => toArrayOrNull($this->city),
            'createdAt'       => $this->createdAt,
            'updatedAt'       => $this->updatedAt,
        ]));
    }

    /**
     * User Repository
     *
     * @return AreaRepository
     */
    public static function repository(): AreaRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
