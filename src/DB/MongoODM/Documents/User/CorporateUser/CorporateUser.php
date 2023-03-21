<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\CorporateUser;

use Delta4op\MongoODM\Traits\DefaultJWTSubjectStubs;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use Tymon\JWTAuth\Contracts\JWTSubject;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class CorporateUser extends User implements JWTSubject
{
    use DefaultJWTSubjectStubs;

    public $type = 'CORPORATE_USER';

    /**
     * @var int
     * @ODM\Field(type="int")
     *
    */
    public $corporateAccountID;

    /**
     * @var ?int[]
     * @ODM\Field(type="collection")
     *
     */
    public $corporateBranchIDs;

    /**
     * @var string
     * @ODM\Field(type="string")
     *
     */
    public $corporateUserRole;
    public const CORPORATE_USER_ROLE_ADMIN = 'ADMIN';
    public const CORPORATE_USER_ROLE_USER = 'USER';

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