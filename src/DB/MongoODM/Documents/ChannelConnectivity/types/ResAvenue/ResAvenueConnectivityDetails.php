<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelConnectivity\types\ResAvenue;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class ResAvenueConnectivityDetails extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     *
     */
    public $username;

    /**
     * @var string
     * @ODM\Field(type="string")
     *
     */
    public $password;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}