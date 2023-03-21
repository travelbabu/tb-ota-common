<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class Verification extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field (type="string")
     */
    public $status;
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_REJECTED = 'REJECTED';

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isAutoApproved;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $remark;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $causer;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $verifiedAt;

    /**
     * @return Verification
     */
    public static function defaultDocument(): Verification
    {
        return new self([
            'status' => self::STATUS_PENDING
        ]);
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
