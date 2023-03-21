<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyRateLinkage;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class Mapping extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Id
     */
    public $operator;
    public const OPERATOR_PLUS = 'PLUS';
    public const OPERATOR_MINUS = 'MINUS';

    /**
     * @var string
     * @ODM\Id
     */
    public $operandType;
    public const OPERAND_TYPE_FLAT = 'FLAT';
    public const OPERAND_TYPE_PERCENTAGE = 'PERCENTAGE';

    /**
     * @var float
     * @ODM\Field (type="float")
     */
    public $operandValue;

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'operation'    => $this->operation,
            'operandType'  => $this->operand,
            'operandValue' => $this->value,
        ]);
    }
}
