<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\Helpers\Parsers\AgePolicyParser;

/**
 * @ODM\EmbeddedDocument
 */
class GuestIdentityPolicy extends EmbeddedDocument
{
    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isLocalIDAllowed;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $documentsRequiredOnCheckIn;

    /**
     * @var array
     * @ODM\Field(type="collection")
     */
    public $acceptableIdentityProofs;
    public const ACCEPTABLE_ID_PAN = 'PAN';
    public const ACCEPTABLE_ID_AADHAR = 'AADHAR';
    public const ACCEPTABLE_ID_DRIVING_LICENCE = 'DRIVING_LICENCE';

    /**
     * @return array
     */
    public function getRulesStringArray(): array
    {
        $arr = [];
        if (isset($this->isLocalIDAllowed)) {
            $arr[] = 'Guest with local IDs are ' . ($this->isLocalIDAllowed ? 'allowed' : 'NOT allowed') . ' at the property. ';
        }

        if (isset($this->isLocalIDAllowed)) {
            $arr[] = ($this->isLocalIDAllowed)
                        ? 'ID proofs are required for all guests while check in'
                        : 'ID proofs are NOT required while check in';
        }

        return $arr;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'isLocalIDAllowed' => $this->isLocalIDAllowed,
            'documentsRequiredOnCheckIn' => $this->documentsRequiredOnCheckIn,
            'acceptableIdentityProofs' => $this->acceptableIdentityProofs,
        ];
    }
}
