<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount\AgentAccount;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class AgentAccountReference extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $companyName;

    /**
     * @param AgentAccount $account
     * @return AgentAccountReference
     */
    public static function createFromAgentAccount(AgentAccount $account): AgentAccountReference
    {
        return new self([
            'id' => $account->id,
            'companyName' => $account->company->name ?? '',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'type' => $this->companyName,
        ]);
    }
}
