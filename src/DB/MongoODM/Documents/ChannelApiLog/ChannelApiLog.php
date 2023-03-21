<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelApiLog;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(collection="channelApiLogs")
 */
class ChannelApiLog extends Document
{
    use HasRepository, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'channelApiLogs';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var Request
     * @ODM\EmbeddedDocument (targetclass=Request::class")
     */
    public $request;

    /**
     * @var Response
     * @ODM\EmbeddedDocument (targetclass=Request::class")
     */
    public $response;

    /**
     * @var string
     * @ODM\string(type="string")
     */
    public $direction;
    public const REQUEST_DIRECTION_INCOMING = 'INCOMING';
    public const REQUEST_DIRECTION_OUTGOING = 'OUTGOING';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_PARTIAL = 'PENDING';
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_FAILURE = 'FAILURE';

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'        => $this->id,
            'request'   => $this->request->toArray(),
            'response'  => $this->response->toArray(),
            'direction' => $this->direction,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);
    }
}
