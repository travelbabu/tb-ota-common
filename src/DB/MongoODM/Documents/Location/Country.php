<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location;

use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CountryRepository;

/**
 * @ODM\Document(
 *     collection="geoCountries",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\CountryRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class Country extends LocationItem
{
    use HasTimestamps, CanResolveStringID;

    /**
     * @var string
     * @ODM\Id(type="string",strategy="none")
     */
    public $id;

    /**
     * @inheritdoc
     */
    protected string $collection = 'geoCountries';

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'createdAt'       => $this->createdAt,
            'updatedAt'       => $this->updatedAt,
        ]);
    }

    /**
     * @return Collection
     */
    public function getStates(): Collection
    {
        return State::repository()->getForCountry($this);
    }

    /**
     * User Repository
     *
     * @return CountryRepository
     */
    public static function repository(): CountryRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
