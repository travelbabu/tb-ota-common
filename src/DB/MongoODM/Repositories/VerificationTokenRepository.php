<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Exception;
use Doctrine\ODM\MongoDB\MongoDBException;
use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\VerificationToken;
use function SYSOTEL\OTA\Common\Helpers\documentManager as dm;

class VerificationTokenRepository extends DocumentRepository
{
    protected $defaultOtp = 123412;

    /**
     * @param string $target
     * @param string $type
     * @param bool $invalidateOldTokens
     * @return VerificationToken
     * @throws MongoDBException
     */
    public function createToken(string $target, string $type, bool $invalidateOldTokens = true): VerificationToken
    {
        if($invalidateOldTokens) {
            $this->markAllAsExpired(VerificationToken::repository()->findBy([
                'type' => $type,
                'target' => $target,
                'status' => VerificationToken::STATUS_ACTIVE
            ]));
        }

        $otp = (!app()->environment('prod'))
            ? $this->defaultOtp
            : random_int(100000, 999999);

        $token = new VerificationToken([
            'type' => $type,
            'target' => $target,
            'token' => $otp,
        ]);

        dm()->persist($token);
        dm()->flush();

        return $token;
    }

    /**
     * @param string $target
     * @param string $type
     * @return VerificationToken|null
     */
    public function getLatestToken(string $target, string $type): ?VerificationToken
    {
        return $this->findOneBy(
            ['target' => $target,'type' => $type],
            ['createdAt' => -1]
        );
    }

    /**
     * @param string $mobileNumber
     * @param bool $invalidateOldTokens
     * @return VerificationToken
     * @throws MongoDBException
     */
    public function createMobileVerificationToken(string $mobileNumber, bool $invalidateOldTokens = true): VerificationToken
    {
        return $this->createToken(
            $mobileNumber,
            VerificationToken::TOKEN_MOBILE_VERIFICATION,
            $invalidateOldTokens
        );
    }

    /**
     * @param string $mobileNumber
     * @param bool $invalidateOldTokens
     * @return VerificationToken
     * @throws MongoDBException
     * @throws Exception
     */
    public function createMobileLoginToken(string $mobileNumber, bool $invalidateOldTokens = true): VerificationToken
    {
        return $this->createToken(
            $mobileNumber,
            VerificationToken::TOKEN_MOBILE_LOGIN,
            $invalidateOldTokens
        );
    }

    /**
     * @param string $email
     * @param bool $invalidateOldTokens
     * @return VerificationToken
     * @throws MongoDBException
     * @throws Exception
     */
    public function createEmailLoginToken(string $email, bool $invalidateOldTokens = true): VerificationToken
    {
        return $this->createToken(
            $email,
            VerificationToken::TOKEN_EMAIL_LOGIN,
            $invalidateOldTokens
        );
    }

    /**
     * @param string $mobileNumber
     * @return VerificationToken|null
     */
    public function getLatestMobileVerificationToken(string $mobileNumber): ?VerificationToken
    {
        return $this->getLatestToken($mobileNumber, VerificationToken::TOKEN_MOBILE_VERIFICATION);
    }

    /**
     * @param string $mobileNumber
     * @return VerificationToken|null
     * @throws Exception
     */
    public function getLatestMobileLoginToken(string $mobileNumber): ?VerificationToken
    {
        return $this->getLatestToken($mobileNumber, VerificationToken::TOKEN_MOBILE_LOGIN);
    }

    /**
     * @param string $email
     * @return VerificationToken|null
     * @throws Exception
     */
    public function getLatestEmailLoginToken(string $email): ?VerificationToken
    {
        return $this->getLatestToken($email, VerificationToken::TOKEN_EMAIL_LOGIN);
    }


    /**
     * @param VerificationToken[] $tokens
     * @throws MongoDBException
     */
    protected function markAllAsExpired(array $tokens)
    {
        foreach($tokens as $token) {
            $token->markAsExpired();
            dm()->persist($token);
            dm()->flush();
        }
    }
}
