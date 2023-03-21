<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CityReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\CountryReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GeoLocation;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\StateReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Traits\HasSearchKeywords;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\AreaRepository;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(collection="geoCityDump")
 */
class CityDump extends Document
{
    use HasRepository;

    /**
     * @inheritdoc
     */
    protected string $collection = 'geoCityDump';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @ODM\Field(type="raw")
     */
    public $dump;


    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'    => $this->id,
            'dump'  => $this->dump,
        ]);
    }
}
