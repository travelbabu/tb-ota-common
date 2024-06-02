<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\CloseOnArrival;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\CloseOnDeparture;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Cutoff;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\DoubleRate;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\ExtraAdultRate;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\ExtraChildRate;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\MaxLos;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\MinLos;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\StopSell;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\QuadRate;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\SingleRate;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\TripleRate;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class StandardProductAttributes extends EmbeddedDocument
{
    /**
     * @var string
     */
    public $attributeType = 'STANDARD';

    public const KEY_SINGLE_RATE = 'singleRate';
    public const KEY_DOUBLE_RATE = 'doubleRate';
    public const KEY_TRIPLE_RATE = 'tripleRate';
    public const KEY_QUAD_RATE = 'quadRate';
    public const KEY_EXTRA_ADULT_RATE = 'extraAdultRate';
    public const KEY_EXTRA_CHILD_RATE = 'extraChildRate';
    public const KEY_STOP_SELL = 'stopSell';
    public const KEY_CLOSE_ON_ARRIVAL = 'closeOnArrival';
    public const KEY_CLOSE_ON_DEPARTURE = 'closeOnDeparture';
    public const KEY_CUTOFF = 'cutoff';
    public const KEY_MIN_LOS = 'minLos';
    public const KEY_MAX_LOS = 'maxLos';

    /**
     * @var SingleRate
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\SingleRate::class)
     */
    public $singleRate;

    /**
     * @var DoubleRate
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\DoubleRate::class)
     */
    public $doubleRate;

    /**
     * @var TripleRate
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\TripleRate::class)
     */
    public $tripleRate;

    /**
     * @var QuadRate
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\QuadRate::class)
     */
    public $quadRate;

    /**
     * @var ExtraAdultRate
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\ExtraAdultRate::class)
     */
    public $extraAdultRate;

    /**
     * @var ExtraChildRate
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\ExtraChildRate::class)
     */
    public $extraChildRate;

    /**
     * @var StopSell
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\StopSell::class)
     */
    public $stopSell;

    /**
     * @var CloseOnArrival
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\CloseOnArrival::class)
     */
    public $closeOnArrival;

    /**
     * @var CloseOnDeparture
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\CloseOnDeparture::class)
     */
    public $closeOnDeparture;

    /**
     * @var Cutoff
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Cutoff::class)
     */
    public $cutoff;

    /**
     * @var MinLos
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\MinLos::class)
     */
    public $minLos;

    /**
     * @var MaxLos
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\MaxLos::class)
     */
    public $maxLos;

    public function toArray(): array
    {
        return arrayFilter([
            'singleRate' => toArrayOrNull($this->singleRate),
            'doubleRate' => toArrayOrNull($this->doubleRate),
            'tripleRate' => toArrayOrNull($this->tripleRate),
            'quadRate' => toArrayOrNull($this->quadRate),
            'extraAdultRate' => toArrayOrNull($this->extraAdultRate),
            'extraChildRate' => toArrayOrNull($this->extraChildRate),
            'stopSell' => toArrayOrNull($this->stopSell),
            'closeOnArrival' => toArrayOrNull($this->closeOnArrival),
            'closeOnDeparture' => toArrayOrNull($this->closeOnDeparture),
            'cutoff' => toArrayOrNull($this->cutoff),
            'minLos' => toArrayOrNull($this->minLos),
            'maxLos' => toArrayOrNull($this->maxLos),
        ]);
    }
}
