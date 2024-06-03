<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog\Dedicated\RateUpdate;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyRateReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyRestrictionsReference;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class RateUpdateLogDetails extends EmbeddedDocument
{
    /**
     * @var ArrayCollection & RateUpdateItem[]
     * @ODM\EmbedMany(targetDocument=RateUpdateItem::class)
     */
    public $rateUpdates;

    /**
     * @var ArrayCollection & PropertyRateReference[]
     * @ODM\EmbedMany(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyRateReference::class)
     */
    public $rateRefs;

    /**
     * @var ArrayCollection & PropertyRestrictionsReference[]
     * @ODM\EmbedMany(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyRestrictionsReference::class)
     */
    public $restrictionsRefs;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->rateUpdates = new ArrayCollection;
        $this->rateRefs = new ArrayCollection;
        $this->restrictionsRefs = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'rateUpdates' => collect($this->rateUpdates)->toArray(),
            'rateRefs' => collect($this->rateRefs)->toArray(),
        ]);
    }
}
