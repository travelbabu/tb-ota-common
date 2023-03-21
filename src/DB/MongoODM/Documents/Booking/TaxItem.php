<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class TaxItem extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;
    public const TYPE_GST = 'GST';
    public const TYPE_IGST = 'IGST';
    public const TYPE_CGST = 'CGST';
    public const TYPE_SGST = 'SGST';

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $amount;

    /**
     * @var float
     * @ODM\Field(type="float")
     */
    public $percentage;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'percentage' => $this->percentage,
            'type' => $this->type,
            'amount' => $this->amount,
        ];
    }
}
