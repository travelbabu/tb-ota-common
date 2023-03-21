<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySearchRecord;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use MongoDB\BSON\ObjectId;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PopularDestination extends EmbeddedDocument
{
    /**
     * @var ObjectId
     * @ODM\Field (type="object_id")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field (type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field (type="string")
     */
    public $type;
    public const TYPE_CITY = 'CITY';
    public const TYPE_AREA = 'AREA';

    /**
     * @var int
     * @ODM\Field (type="int")
     */
    public $propertyCount;


    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => (string) $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'propertyCount' => $this->propertyCount,
        ]);
    }
}
