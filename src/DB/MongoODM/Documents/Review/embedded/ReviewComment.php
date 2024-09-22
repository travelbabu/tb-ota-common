<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\embedded;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class ReviewComment extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="string")
     */
    public $_id;

    /**
     * @var ?int
     * @ODM\Field(type="string")
     */
    public $language;
    /**
     * @var ?int
     * @ODM\Field(type="string")
     */
    public $heading;
    /**
     * @var ?int
     * @ODM\Field(type="string")
     */
    public $body;
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $commenterID;
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $commenterFirstName;
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $commenterLastName;
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $commenterFullName;
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $commenterType;
    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $timestamp;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            
        ]);
    }
}
