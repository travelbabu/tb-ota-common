<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Carbon\Carbon;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class Request extends EmbeddedDocument
{
    use HasTimestamps;


    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $method;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $endpoint;

    /**
     * @var ArrayCollection & KeyValueItem
     * @ODM\EmbedMany (targetDocument=KeyValueItem::class)
     */
    public $headers;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $payload;

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->headers = new ArrayCollection;

        parent::__construct($attributes);
    }

    public function setHeadersFromArray(array $headers): self
    {
        $this->headers = new ArrayCollection;
        foreach($headers as $key => $value) {
            $this->headers->add(new KeyValueItem(compact('key', 'value')));
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'method' => $this->method,
            'endpoint' => $this->endpoint,
            'headers' => collect($this->headers)->toArray(),
            'payload' => $this->payload,
        ]);
    }
}
