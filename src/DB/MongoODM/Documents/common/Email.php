<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Illuminate\Support\Str;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class Email extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $verificationToken;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $verifiedAt = null;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $forceVerified;

    /**
     * @return $this
     */
    public function forceVerify(): static
    {
        $this->forceVerified = true;
        $this->markAsVerified();
        return $this;
    }

    /**
     * @param string|null $token
     * @return $this
     */
    public function setVerificationToken(?string $token = null): static
    {
        $this->verificationToken = $token ?? Str::random(30);

        return $this;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return isset($this->verifiedAt);
    }

    /**
     * @return void
     */
    public function markAsVerified(): void
    {
        $this->verifiedAt = now();
    }

    /**
     * @return $this
     */
    public function generateVerificationToken(): static
    {
        $this->verificationToken = Str::random(32);

        return $this;
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'id'                => $this->id,
            'verificationToken' => $this->verificationToken,
            'verifiedAt'        => $this->verifiedAt,
        ]);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->id;
    }
}
