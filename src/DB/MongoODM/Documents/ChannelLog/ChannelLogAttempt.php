<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog;

use Doctrine\Common\Collections\ArrayCollection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ApiLogReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ExecutionDetails;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class ChannelLogAttempt extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var ?ExecutionDetails
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ExecutionDetails::class)
     */
    public $execution;

    /**
     * @var ?ApiLogReference
     * @ODM\EmbedMany(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ApiLogReference::class)
     */
    public $apiLogs;

    public function __construct(array $attributes = [])
    {
        $this->apiLogs = new ArrayCollection();

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'status' => $this->status,
        ]);
    }
}
