<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Carbon\Carbon;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class Password extends EmbeddedDocument
{
    use HasTimestamps;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $hash;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $createdAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $updatedAt;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $resetToken;

    /**
     * @param string|null $token
     * @return $this
     */
    public function setResetToken(?string $token = null): static
    {
        $this->resetToken = $token ?? Str::random(30);

        return $this;
    }

    /**
     * @param string $password
     * @param string|null $resetToken
     * @return $this
     */
    public function setPassword(string $password, string $resetToken = null): static
    {
        if ($resetToken) {
            if ($resetToken != $this->resetToken) {
                throw new HttpException('Invalid reset token');
            }

            $this->resetToken = null;
            $this->lastResetAt = now();
        }

        $this->hash = $this->createHash($password);

        return $this;
    }

    /**
     * Sets hashed password
     *
     * @param string $password
     * @return bool
     * @author Ravish
     */
    public function validate(string $password): bool
    {
        return Hash::check($password, $this->hash);
    }

    /**
     * Returns hashed password
     *
     * @param string $password
     * @return string
     */
    public function createHash(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'hash' => $this->hash,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->hash ?? '';
    }
}
