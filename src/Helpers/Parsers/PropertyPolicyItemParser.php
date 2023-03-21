<?php

namespace SYSOTEL\OTA\Common\Helpers\Parsers;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\PropertyRules;

class PropertyPolicyItemParser
{
    protected PropertyRules $policyItem;

    protected $mapping = [
        PropertyRules::COUPLE_FRIENDLY => ['Property is couple friendly.' , 'Property is NOT couple friendly.'],
        PropertyRules::DOCUMENTS_REQUIRED_WHILE_CHECK_IN => ['Documents are required while check In.', 'Documents are NOT required while check In.'],
        PropertyRules::LOCAL_ID_ALLOWED => ['Guests with local IDs are allowed.', 'Guests with local IDs are NOT allowed.'],
        PropertyRules::PAYMENT_CARD_ACCEPTED => ['Payment cards are accepted.', 'Payment cards are NOT accepted.'],
        PropertyRules::PET_ALLOWED => ['Pets are allowed.', 'Pets are NOT allowed.'],
        PropertyRules::SUITABLE_FOR_CHILDREN => ['Suitable for children.', 'NOT Suitable for children.'],
    ];

    public function __construct(PropertyRules $policyItem)
    {
        $this->policyItem = $policyItem;
    }

    /**
     * @return string
     */
    public function description(): string
    {
        $index = $this->policyItem->flag === true ? 0 : 1;

        return $this->mapping[$this->policyItem->type][$index];
    }
}