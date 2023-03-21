<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySearchRecord;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class SearchFilters extends EmbeddedDocument
{
    /**
     * @var array & int[]
     * @ODM\Field(type="collection")
     */
    public $starRatings = [];

    /**
     * @var array & string[]
     * @ODM\Field(type="collection")
     */
    public $propertyTypes = [];

    /**
     * @var array & string[]
     * @ODM\Field(type="collection")
     */
    public $highlights = [];

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'starRating' => $this->starRating,
            'propertyTypes' => $this->propertyTypes,
            'highlights' => $this->highlights,
        ]);
    }
}
