<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class PersonName extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $title;
    public const TITLE_MR = 'MR';
    public const TITLE_MS = 'MS';
    public const TITLE_MRS = 'MRS';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $firstName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $lastName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $fullName;

    /**
     * @param string $firstName
     * @param string $lastName
     * @return PersonName
     */
    public function setName(string $firstName, string $lastName): static
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->fullName = $this->firstName . ' ' . $this->lastName;
        return $this;
    }


    /**
     * @ODM\PrePersist
     * @ODM\PreUpdate
     */
    public function onPrePersist()
    {
        if(!$this->fullName) {
            $this->fullName = $this->firstName . ' ' . $this->lastName;
        }
    }

    /**
     * @return string
     */
    public function fullNameWithTitle(): string
    {
        if(!$this->title) {
            return $this->fullName;
        }

        return $this->title . ' ' . $this->fullName;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'fullName' => $this->fullName,
        ];
    }
}
