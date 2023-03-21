<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySearchRecord;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class SearchCauser extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $userID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $userType;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $ip;

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'userID' => $this->userID,
            'userType' => $this->userType,
            'ip' => $this->ip,
        ]);
    }
}
