<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy\Types\Custom;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy\CancellationPolicy;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class CustomCancellationPolicy extends EmbeddedDocument
{

    public $type = CancellationPolicy::TYPE_CUSTOM;

    /**
     * @var string
     * @ODM\Field (type="string")
     */
    public $description;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'type' => $this->type,
            'description' => $this->description,
        ]);
    }
}
