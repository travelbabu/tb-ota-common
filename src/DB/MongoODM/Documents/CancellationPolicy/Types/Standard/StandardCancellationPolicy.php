<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy\Types\Standard;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CancellationPolicy\CancellationPolicy;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class StandardCancellationPolicy extends EmbeddedDocument
{
    public $type = CancellationPolicy::TYPE_STANDARD;

    /**
     * @var CancellationPenalty
     * @ODM\EmbedOne (targetDocument=CancellationPenalty::class)
    */
    public $noShowPenalty;

    /**
     * @var ArrayCollection
     * @ODM\EmbedMany (targetDocument=CancellationRule::class)
     */
    public $rules;

    public function __construct(array $attributes = [])
    {
        $this->rules = new ArrayCollection;

        parent::__construct($attributes);
    }
    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'type'  => $this->type,
            'noShowPenalty'  => toArrayOrNull($this->noShowPenalty),
            'rules'  => collect($this->rules)->toArray(),
        ]);
    }
}
