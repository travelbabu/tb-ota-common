<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class SpaceSize extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $widthFT;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $lengthFT;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $areaSQFT;

    /**
     * @ODM\PrePersist
    */
    protected function setArea()
    {
        $this->areaSQFT = $this->widthFT * $this->lengthFT;
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([
            'widthFT'  => $this->widthFT,
            'lengthFT' => $this->lengthFT,
            'areaSQFT' => $this->areaSQFT,
        ]);
    }
}
