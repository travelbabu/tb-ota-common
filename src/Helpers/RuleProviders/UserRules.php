<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use SYSOTEL\OTA\Common\Rules\Exists;
use SYSOTEL\OTA\Common\Rules\User\DoesNotHavePassword;
use SYSOTEL\OTA\Common\Rules\User\EmailExists;
use SYSOTEL\OTA\Common\Rules\User\MobileNumberExists;
use SYSOTEL\OTA\Common\Rules\User\Password;
use SYSOTEL\OTA\Common\Rules\User\PasswordExists;
use SYSOTEL\OTA\Common\Rules\User\UniqueEmail;
use SYSOTEL\OTA\Common\Rules\User\UniqueMobileNumber;

class UserRules
{
    /**
     * @param array $filters
     * @return Exists
     */
    public static function exists(array $filters = []): Exists
    {
        return new Exists(User::class, '_id', $filters);
    }

    /**
     * @return Password
     */
    public static function strongPassword(): Password
    {
        return new Password();
    }

    /**
     * @param string $userType
     * @return UniqueEmail
     */
    public static function uniqueEmail(string $userType): UniqueEmail
    {
        return new UniqueEmail($userType);
    }

    /**
     * @param string $userType
     * @return UniqueMobileNumber
     */
    public static function uniqueMobileNumber(string $userType): UniqueMobileNumber
    {
        return new UniqueMobileNumber($userType);
    }

    /**
     * @param string $userType
     * @return EmailExists
     */
    public static function emailExists(string $userType): EmailExists
    {
        return new EmailExists($userType);
    }

    /**
     * @param string $userType
     * @return MobileNumberExists
     */
    public static function mobileNumberExists(string $userType): MobileNumberExists
    {
        return new MobileNumberExists($userType);
    }

    /**
     * @return PasswordExists
     */
    public static function passwordExists(): PasswordExists
    {
        return new PasswordExists();
    }

    /**
     * @return DoesNotHavePassword
     */
    public static function passwordDoesNotExists(): DoesNotHavePassword
    {
        return new DoesNotHavePassword();
    }

    /**
     * @return In
     */
    public static function validExtranetUserType(): In
    {
        return Rule::in([
            User::TYPE_EXTRANET_USER,
            User::TYPE_ADMIN,
        ]);
    }

    /**
     * @return In
     */
    public static function validUserType(): In
    {
        return Rule::in([
            User::TYPE_EXTRANET_USER,
            User::TYPE_ADMIN,
            User::TYPE_GUEST,
        ]);
    }

    /**
     * @return In
     */
    public static function validStatus(): In
    {
        return Rule::in([
            User::STATUS_ACTIVE,
            User::STATUS_BLOCKED,
        ]);
    }
}
