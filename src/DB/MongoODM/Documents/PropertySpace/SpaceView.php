<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class SpaceView extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const OCEAN_VIEW = 'OCEAN_VIEW';
    public const MOUNTAIN_VIEW = 'MOUNTAIN_VIEW';
    public const VALLEY_VIEW = 'VALLEY_VIEW';
    public const PALACE_VIEW = 'PALACE_VIEW';
    public const JUNGLE_VIEW = 'BAY_VIEW';
    public const CITY_VIEW = 'CITY_VIEW';
    public const GARDEN_VIEW = 'GARDEN_VIEW';
    public const LAKE_VIEW = 'LAKE_VIEW';
    public const POOL_VIEW = 'POOL_VIEW';
    public const RIVER_VIEW = 'RIVER_VIEW';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $customType;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'type'  => $this->type,
            'customType' => $this->customType,
        ]);
    }
}
