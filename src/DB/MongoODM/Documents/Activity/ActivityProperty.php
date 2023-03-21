<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class ActivityProperty extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @param Property $property
     * @return ActivityProperty
     */
    public static function createFromProperty(Property $property): ActivityProperty
    {
        return new self([
            'id' => $property->id,
            'name' => $property->displayName,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'     => $this->id,
            'name'   => $this->name,
        ]);
    }
}
