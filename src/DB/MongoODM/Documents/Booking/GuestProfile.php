<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class GuestProfile extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field (type="int")
     */
    public $_id;

    /**
     * @var ?int
     * @ODM\Field (type="int")
     */
    public $spaceNo;

    /**
     * @var ?bool
     * @ODM\Field (type="bool")
     */
    public $isPrimary;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $ageCode;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $age;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $rateLevel;


    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $title;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $firstName;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $lastName;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    public $fullName;

    /**
     * @var ?bool
     * @ODM\Field (type="bool")
     */
    public $isChargeable;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            '_id' => $this->_id,
        ];
    }
}
