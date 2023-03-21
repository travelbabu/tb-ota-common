<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Agent;

use Delta4op\MongoODM\Traits\DefaultJWTSubjectStubs;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use Tymon\JWTAuth\Contracts\JWTSubject;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class Agent extends User implements JWTSubject
{
    use DefaultJWTSubjectStubs;

    public $type = 'AGENT';

    /**
     * @var int
     * @ODM\Field(type="int")
     *
    */
    public $agentAccountID;

    /**
     * @var string
     * @ODM\Field(type="string")
     *
     */
    public $agentRole;
    public const AGENT_ROLE_ADMIN = 'ADMIN';
    public const AGENT_ROLE_USER = 'USER';

    /**
     * @var string
     * @ODM\Field(type="string")
     *
     */
    public $agentAccountType;

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