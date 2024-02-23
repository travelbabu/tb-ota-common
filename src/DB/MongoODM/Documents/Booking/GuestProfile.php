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
     * @var int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var ?int
     * @ODM\Field (type="int")
     */
    protected $no;

    /**
     * @var ?int
     * @ODM\Field (type="int")
     */
    protected $spaceNo;

    /**
     * @var ?bool
     * @ODM\Field (type="bool")
     */
    protected $isPrimary;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $ageCode;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    protected $age;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $rateLevel;


    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    protected $title;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    protected $firstName;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    protected $lastName;

    /**
     * @var ?string
     * @ODM\Field (type="string")
     */
    protected $fullName;

    /**
     * @var ?bool
     * @ODM\Field (type="bool")
     */
    protected $isChargeable;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
