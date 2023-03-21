<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccountSettings;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class AgentCommission extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $valueType;
    public const VALUE_TYPE_FLAT = 'FLAT';
    public const VALUE_TYPE_PERC = 'PERC';

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $value;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'valueType'  => $this->valueType,
            'value' => $this->value,
        ]);
    }
}
