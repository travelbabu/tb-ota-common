<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\City;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\State;
use function SYSOTEL\OTA\Common\Helpers\googleMapURL;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class StateReference extends EmbeddedDocument
{
    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $slug;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $code;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @param State $state
     * @return StateReference
     */
    public static function createFromState(State $state): StateReference
    {
        return new self([
            'id' => new ObjectId($state->id),
            'slug' => $state->slug,
            'code' => $state->code,
            'name' => $state->name,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
        ]);
    }
}
