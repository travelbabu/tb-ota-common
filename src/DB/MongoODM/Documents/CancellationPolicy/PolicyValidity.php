<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PolicyValidity extends EmbeddedDocument
{
    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $from;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $to;

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return !$this->isPreMature() && !$this->isExpired();
    }

    /**
     * @return bool
     */
    public function isPremature(): bool
    {
        return today()->lte($this->from->startOfDay());
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return today()->gt($this->to->startOfDay());
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'from' => $this->from,
            'to'   => $this->to,
        ]);
    }
}
