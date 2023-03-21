<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\CommandLog;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Illuminate\Support\Traits\Macroable;

/**
 * @ODM\Document(
 *     collection="commandLogs"
 * )
 */
class CommandLog extends Document
{
    use Macroable, HasDefaultAttributes, HasRepository;

    /**
     * @inheritdoc
     */
    protected string $collection = 'commandLogs';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $env;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $command;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_PENDING = 'PENDING';
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_FAILURE = 'FAILURE';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $output;

    /**
     * @var array
     * @ODM\Field(type="raw")
     */
    public $exception;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $startedAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $completedAt;


    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([

        ]);
    }
}
