<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyRateLinkage;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Delta4op\MongoODM\Facades\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\ChannelRepository;

/**
 * @ODM\Document(
 *     collection="productRateLinks",
 * )
 */
class ProductRateMapping extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Id
     */
    public $baseProductID;

    /**
     * @ODM\EmbedMany (targetDocument=MappedProduct::class)
     */
    public $mappedProducts;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([

        ]);
    }
}
