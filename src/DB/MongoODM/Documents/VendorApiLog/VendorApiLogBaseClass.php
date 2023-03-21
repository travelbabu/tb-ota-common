<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\VendorApiLog;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Request;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Response;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\MappedSuperclass
 * @ODM\HasLifecycleCallbacks
 */
abstract class VendorApiLogBaseClass extends Document
{
    use HasTimestamps, HasRepository;

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $externalReferenceID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $endpoint;

    /**
     * @var Request
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Request::class)
     */
    public $request;

    /**
     * @var Response
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Response::class)
     */
    public $response;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_ERROR = 'ERROR';
    public const STATUS_FAILURE = 'FAILURE';


    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'externalReferenceID' => $this->externalReferenceID,
            'endpoint' => $this->endpoint,
            'request' => toArrayOrNull($this->request),
            'response' => toArrayOrNull($this->response),
            'status' => $this->status,
            'createdAt' => $this->createdAt,
        ]);
    }
}
