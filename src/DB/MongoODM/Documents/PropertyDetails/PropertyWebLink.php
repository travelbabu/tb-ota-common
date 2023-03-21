<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDetails;

use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\googleMapURL;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyWebLink extends EmbeddedDocument
{
    use HasDefaultAttributes;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $key;
    public const KEY_FACEBOOK = 'Facebook';
    public const KEY_TWITTER = 'Twitter';
    public const KEY_LINKEDIN = 'Linkedin';
    public const KEY_WEBSITE = 'Website';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $url;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isActive;
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';

    /**
     * Default values for document creation
     * @var array
     */
    public $defaults = [
        'status' => self::STATUS_ACTIVE
    ];

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'facebook' => $this->key,
            'twitter'  => $this->url,
            'status'   => $this->status,
        ]);
    }
}
