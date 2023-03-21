<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\Helpers\Parsers\AgePolicyParser;

/**
 * @ODM\EmbeddedDocument
 */
class AgePolicy extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $infantAgeThreshold;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $childAgeThreshold;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $freeChildThreshold;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $noOfFreeChildGranted;

    /**
     * @return AgePolicyParser
     */
    public function parser(): AgePolicyParser
    {
        return new AgePolicyParser($this);
    }

    /**
     * @return array
     */
    public function ageRulesArray(): array
    {
        return [
            $this->parser()->infantAgeDefinition(),
            $this->parser()->childAgeDefinition(),
            $this->parser()->adultAgeDefinition(),
            $this->parser()->freeChildDefinition(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'infantAgeThreshold' => $this->infantAgeThreshold,
            'childAgeThreshold' => $this->childAgeThreshold,
            'freeChildThreshold' => $this->freeChildThreshold,
            'noOfFreeChildGranted' => $this->noOfFreeChildGranted,
        ];
    }
}
