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
class Mobile extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $countryCode;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $number;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $verificationToken;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $verifiedAt;

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
     * @return bool|null
     */
    public function isVerified(): ?bool
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
     * @return string
     */
    public function stringValue(): string
    {
        $str = '';
        if($this->countryCode) {
            $str .= '+'. $this->countryCode . ' ';
        }

        $str .= $this->number;
        return $str;
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'countryCode'       => $this->countryCode,
            'number'            => $this->number,
            'verificationToken' => $this->verificationToken,
            'verifiedAt'        => $this->verifiedAt,
        ]);
    }
}
