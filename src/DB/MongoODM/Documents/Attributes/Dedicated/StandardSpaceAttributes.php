<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Dedicated;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Activity\ActivityType;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\AvailableUnits;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\CloseOnArrival;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\CloseOnDeparture;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\Cutoff;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\MaxLos;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\MinLos;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\StopSell;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class StandardSpaceAttributes extends EmbeddedDocument
{
    /**
     * @var string
     */
    public $attributeType = 'STANDARD';

    public const KEY_AVAILABLE_UNITS = 'availableUnits';
    public const KEY_STOP_SELL = 'stopSell';
    public const KEY_CLOSE_ON_ARRIVAL = 'closeOnArrival';
    public const KEY_CLOSE_ON_DEPARTURE = 'closeOnDeparture';
    public const KEY_CUTOFF = 'cutoff';
    public const KEY_MIN_LOS = 'minLos';
    public const KEY_MAX_LOS = 'maxLos';

    /**
     * @var AvailableUnits
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Attributes\AvailableUnits::class)
     */
    public $availableUnits;

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
            'availableUnits'   => toArrayOrNull($this->availableUnits),
            'stopSell'         => toArrayOrNull($this->stopSell),
            'closeOnArrival'   => toArrayOrNull($this->closeOnArrival),
            'closeOnDeparture' => toArrayOrNull($this->closeOnDeparture),
            'cutoff'           => toArrayOrNull($this->cutoff),
            'minLos'           => toArrayOrNull($this->minLos),
            'maxLos'           => toArrayOrNull($this->maxLos),
        ]);
    }
}
