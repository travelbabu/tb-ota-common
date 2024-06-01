<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelLog;

use Doctrine\Common\Collections\ArrayCollection;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class ChannelLogAttemptDetails extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $attemptCount;

    /**
     * @var ?ChannelLogAttempt
     * @ODM\EmbedMany(targetDocument=ChannelLogAttempt::class)
     */
    public $attempts;

    public function __construct(array $attributes = [])
    {
        $this->attempts = new ArrayCollection();
        $this->calculateAttemptCount();

        parent::__construct($attributes);
    }

    /**
     * @return $this
     */
    public function calculateAttemptCount(): static
    {
        $this->attemptCount = $this->attempts?->count ?? 0;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'attemptCount' => $this->attemptCount,
        ]);
    }
}
