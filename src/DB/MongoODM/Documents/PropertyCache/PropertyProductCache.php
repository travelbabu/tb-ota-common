<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCache;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\TgrDetails;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyProductCache extends EmbeddedDocument
{
    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $spaceID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $displayName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $paymentMode;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $mealPlanCode;

    /**
     * @var string[]
     * @ODM\Field(type="collection")
     */
    public $inclusions = [];

    /**
     * @var PartialPayment
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment::class)
     */
    public $partialPayment;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $sortOrder;

    /**
     * @var TgrDetails
     * @ODM\EmbedOne(targetDocument=TgrDetails::class)
     */
    public $tgrDetails;

    /**
     * @return PropertyProduct
     */
    public function createDummyProductDocument(): PropertyProduct
    {
        return new PropertyProduct([
            'id' => $this->id,
            'supplierID' => $this->supplierID,
            'propertyID' => $this->propertyID,
            'spaceID' => $this->spaceID,
            'displayName' => $this->displayName,
            'paymentMode' => $this->paymentMode,
            'mealPlanCode' => $this->mealPlanCode,
            'inclusions' => $this->inclusions,
            'partialPayment' => $this->partialPayment,
            'sortOrder' => $this->sortOrder,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'                   => $this->id,
            'spaceID'              => $this->spaceID,
            'displayName'          => $this->displayName,
            'mealPlanCode'         => $this->mealPlanCode,
            'tgrDetails'           => toArrayOrNull($this->tgrDetails),
        ]);
    }
}
