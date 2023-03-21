<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\Country;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\State;
use function SYSOTEL\OTA\Common\Helpers\googleMapURL;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class CountryReference extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
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
     * @param Country $country
     * @return CountryReference
     */
    public static function createFromCountry(Country $country): CountryReference
    {
        return new self([
            'id' => $country->id,
            'slug' => $country->slug,
            'code' => $country->code,
            'name' => $country->name,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'code' => $this->code,
            'name' => $this->name,
        ]);
    }
}
