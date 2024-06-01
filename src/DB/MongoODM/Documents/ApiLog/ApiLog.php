<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog\ApiRequest;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ApiLog\ApiResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ErrorDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ExecutionDetails;

use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="apiLogs",
 * )
 * @ODM\HasLifecycleCallbacks
 */
abstract class ApiLog extends Document
{
    use HasRepository, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'apiLogs';

    /**
     * @var ?string
     * @ODM\Id
     */
    public $id;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $type;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var ?boolean
     * @ODM\Field(type="bool")
     */
    public $isIncoming;

    /**
     * @var ?ApiRequest
     * @ODM\EmbedOne(targetDocument=ApiRequest::class)
     */
    public $request;

    /**
     * @var ?ApiResponse
     * @ODM\EmbedOne(targetDocument=ApiRequest::class)
     */
    public $response;

    /**
     * @var ?ErrorDetails
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ErrorDetails::class)
     */
    public $error;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var ?ExecutionDetails
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ExecutionDetails::class)
     */
    public $executionDetails;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            
        ]);
    }
}
