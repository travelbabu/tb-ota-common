<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyReview;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class Comment extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $title;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $description;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'title'  => $this->title,
            'description'  => $this->description,
        ]);
    }
}
