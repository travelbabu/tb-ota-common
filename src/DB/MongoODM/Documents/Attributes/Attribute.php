<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
abstract class Attribute extends EmbeddedDocument
{
    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isUpdated = self::DEFAULT_IS_UPDATED_VALUE;
    public const DEFAULT_IS_UPDATED_VALUE = true;

    abstract static function getDefaultInstance();
}
