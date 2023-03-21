<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Admin\Admin;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use SYSOTEL\OTA\Common\Rules\User\EmailExists;
use SYSOTEL\OTA\Common\Rules\User\MobileNumberExists;
use SYSOTEL\OTA\Common\Rules\User\UniqueEmail;
use SYSOTEL\OTA\Common\Rules\User\UniqueMobileNumber;

class AdminRules extends UserRules
{
    /**
     * @return In
     */
    public static function validRole(): In
    {
        return new In([
            Admin::ADMIN_ROLE_SUPER_ADMIN,
            Admin::ADMIN_ROLE_ADMIN,
        ]);
    }

    /**
     * @param string $userType
     * @return UniqueEmail
     */
    public static function uniqueEmail(string $userType = User::TYPE_ADMIN): UniqueEmail
    {
        return parent::uniqueEmail($userType);
    }

    /**
     * @param string $userType
     * @return UniqueMobileNumber
     */
    public static function uniqueMobileNumber(string $userType = User::TYPE_ADMIN): UniqueMobileNumber
    {
        return parent::uniqueMobileNumber($userType);
    }

    /**
     * @param string $userType
     * @return EmailExists
     */
    public static function emailExists(string $userType = User::TYPE_ADMIN): EmailExists
    {
        return parent::emailExists($userType);
    }

    /**
     * @param string $userType
     * @return MobileNumberExists
     */
    public static function mobileNumberExists(string $userType = User::TYPE_ADMIN): MobileNumberExists
    {
        return parent::mobileNumberExists($userType);
    }
}
