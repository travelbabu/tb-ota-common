<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyRateLinkage;

use Delta4op\MongoODM\Documents\EmbedOne;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="productRateLinks",
 * )
 */
class MappedProduct extends EmbedOne
{
    /**
     * @var Mapping
     * @ODM\EmbedOne(targetDocument=Mapping::class)
     */
    public $singleRate;

    /**
     * @var Mapping
     * @ODM\EmbedOne(targetDocument=Mapping::class)
     */
    public $doubleRate;

    /**
     * @var Mapping
     * @ODM\EmbedOne(targetDocument=Mapping::class)
     */
    public $tripleRate;

    /**
     * @var Mapping
     * @ODM\EmbedOne(targetDocument=Mapping::class)
     */
    public $quadRate;

    /**
     * @var Mapping
     * @ODM\EmbedOne(targetDocument=Mapping::class)
     */
    public $extraAdultRate;

    /**
     * @var Mapping
     * @ODM\EmbedOne(targetDocument=Mapping::class)
     */
    public $extraChildRate;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'singleRate' => toArrayOrNull($this->singleRate),
            'doubleRate' => toArrayOrNull($this->doubleRate),
            'tripleRate' => toArrayOrNull($this->tripleRate),
            'quadRate' => toArrayOrNull($this->quadRate),
            'extraAdultRate' => toArrayOrNull($this->extraAdultRate),
            'extraChildRate' => toArrayOrNull($this->extraChildRate),
        ]);
    }
}
