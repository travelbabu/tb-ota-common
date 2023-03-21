<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\CanResolveStringID;
use Delta4op\MongoODM\Traits\HasRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(collection="suppliers")
 */
class Supplier extends Document
{
    use CanResolveStringID, HasRepository;

    /**
     * @inheritdoc
     */
    protected string $collection = 'suppliers';

    /**
     * @var string
     * @ODM\Id(strategy="none", type="string")
     */
    public $id;
    public const ID_SELF = 'SELF';
    public const ID_TRAVELGURU = 'TGR';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $name;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'                => $this->id,
            'name'       => $this->name,
        ]);
    }
}
