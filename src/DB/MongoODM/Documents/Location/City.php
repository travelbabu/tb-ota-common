<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location;

use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CountryReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\StateReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CityRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="geoCities",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CityRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class City extends LocationItem
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'geoCities';

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
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), arrayFilter([
            'country'         => toArrayOrNull($this->country),
            'state'           => toArrayOrNull($this->state),
            'createdAt'       => $this->createdAt,
            'updatedAt'       => $this->updatedAt,
        ]));
    }

    /**
     * User Repository
     *
     * @return CityRepository
     */
    public static function repository(): CityRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
