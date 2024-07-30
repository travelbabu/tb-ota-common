<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\embedded;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class PromotionApplicableSpace extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $spaceID;

    /**
     * @var ?boolean
     * @ODM\Field(type="boolean")
     */
    public $applicableOnAllProducts;

    /**
     * @var ArrayCollection & PromotionApplicableProduct[]
     * @ODM\EmbedMany (targetDocument=PromotionApplicableProduct::class)
     */
    public $applicableProducts;

    public function __construct(array $attributes = [])
    {
        $this->applicableProducts = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'applicableOnAllProducts' => $this->applicableOnAllProducts,
        ]);
    }
}
