<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class AppError extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $message;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $code;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $file;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $line;

    /**
     * @var ?string[]
     * @ODM\Field(type="collection")
     */
    public $trace;

    public static function createFromThrowable(\Throwable $throwable): self
    {
        $instance = new self();
        $instance->message = $throwable->getMessage();
        $instance->code = $throwable->getCode();
        $instance->file = $throwable->getFile();
        $instance->line = $throwable->getLine();
        $instance->trace = $throwable->getTrace();

        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
