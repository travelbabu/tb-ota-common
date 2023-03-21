<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyReview;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class Reviewer extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $cityName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $countryName;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'name'  => $this->name,
            'cityName'  => $this->cityName,
            'countryName' => $this->countryName,
        ]);
    }
}
