<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Guest;

use Delta4op\MongoODM\Traits\DefaultJWTSubjectStubs;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use Tymon\JWTAuth\Contracts\JWTSubject;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class Guest extends User implements JWTSubject
{
    use DefaultJWTSubjectStubs;

    public $type = 'GUEST';

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $autoCreated;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter(
            array_merge(parent::toArray(),[

            ])
        );
    }
}