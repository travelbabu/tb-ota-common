<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use SYSOTEL\OTA\Common\Rules\User\EmailExists;
use SYSOTEL\OTA\Common\Rules\User\MobileNumberExists;
use SYSOTEL\OTA\Common\Rules\User\UniqueEmail;
use SYSOTEL\OTA\Common\Rules\User\UniqueMobileNumber;

class ExtranetUserRules extends UserRules
{
    public static function uniqueEmail(string $userType = User::TYPE_EXTRANET_USER): UniqueEmail
    {
        return parent::uniqueEmail($userType);
    }

    public static function uniqueMobileNumber(string $userType = User::TYPE_EXTRANET_USER): UniqueMobileNumber
    {
        return parent::uniqueMobileNumber($userType);
    }

    public static function emailExists(string $userType = User::TYPE_EXTRANET_USER): EmailExists
    {
        return parent::emailExists($userType);
    }

    public static function mobileNumberExists(string $userType = User::TYPE_EXTRANET_USER): MobileNumberExists
    {
        return parent::mobileNumberExists($userType);
    }
}
