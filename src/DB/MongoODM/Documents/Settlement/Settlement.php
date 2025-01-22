<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\common\SettlementBooking;

use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="settlements",
 * )
 * @ODM\HasLifecycleCallbacks
 * @ODM\InheritanceType("type")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({
 *     "BOOKING_PROPERTY":SYSOTEL\OTA\Common\DB\MongoODM\Documents\Settlement\PropertyBooking\PropertySettlementCalculations::class,
 * })
 */
abstract class Settlement extends Document
{
    use HasRepository, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'settlements';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'         => $this->id,
            
        ]);
    }
}
