<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class TgrDetails extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $weekdayRank;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $weekendRank;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $reviewRating;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $reviewCount;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'weekdayRank' => $this->weekdayRank,
            'weekendRank' => $this->weekendRank,
            'reviewRating' => $this->reviewRating,
            'reviewCount' => $this->reviewCount,
        ];
    }
}
