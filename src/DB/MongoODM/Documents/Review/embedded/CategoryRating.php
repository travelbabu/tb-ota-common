<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\embedded;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class CategoryRating extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $category;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $ratingTopLine;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $ratingGiven;

    /**
     * @var ?float
     * @ODM\Field(type="float")
     */
    public $score;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
