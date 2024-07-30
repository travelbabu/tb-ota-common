<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\embedded;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PromotionApplicableSpaceDetails extends EmbeddedDocument
{
    /**
     * @var ?boolean
     * @ODM\Field(type="boolean")
     */
    public $applicableOnAllSpaces;

    /**
     * @var ArrayCollection & PromotionApplicableSpace[]
     * @ODM\EmbedMany (targetDocument=PromotionApplicableSpace::class)
     */
    public $applicableSpaces;

    public function __construct(array $attributes = [])
    {
        $this->applicableSpaces = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'applicableOnAllSpaces' => $this->applicableOnAllSpaces,
        ]);
    }
}
