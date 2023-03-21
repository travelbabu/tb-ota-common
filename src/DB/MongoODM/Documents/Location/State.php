<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location;

use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CountryReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\StateRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="geoStates",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\StateRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class State extends LocationItem
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'geoStates';

    /**
     * @var CountryReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CountryReference::class)
     */
    public $country;

    /**
     * @var string
     * @ODM\Field
     */
    public $code;

    public function getCountry(): ?Country
    {
        return Country::repository()->find($this->country->id);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), arrayFilter([
            'country'  => toArrayOrNull($this->country),
            'code'     => $this->code,
            'createdAt'       => $this->createdAt,
            'updatedAt'       => $this->updatedAt,
        ]));
    }

    /**
     * User Repository
     *
     * @return StateRepository
     */
    public static function repository(): StateRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
