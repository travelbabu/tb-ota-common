<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Throwable;

use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class ErrorDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $message;

    /**
     * @var ?AppError
     * @ODM\EmbedOne(targetDocument=AppError::class)
     */
    public $appError;

    public static function createFromThrowable(Throwable $throwable): self
    {
        $instance = new self();

        $instance->message = $throwable->getMessage();
        $instance->appError = AppError::createFromThrowable($throwable);

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
