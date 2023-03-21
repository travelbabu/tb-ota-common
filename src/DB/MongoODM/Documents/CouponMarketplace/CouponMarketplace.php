<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CouponMarketplace;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="couponMarketplace"
 * )
 * @ODM\HasLifecycleCallbacks
 */
class CouponMarketplace extends Document
{
    use HasTimestamps, HasRepository;

    /**
     * @inheritdoc
     */
    protected string $collection = 'couponMarketplace';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_BBRSILVER = 'BBRSILVER';
    public const TYPE_BBRGOLD = 'BBRGOLD';
    public const TYPE_BBRPLATINUM = 'BBRPLATINUM';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $code;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $tagline;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $description;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $terms;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $purchaseValue;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isActive;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $sortOrder;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
