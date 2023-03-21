<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\ChannelMapping\ChannelMapping;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

class ChannelMappingRules
{
    /**
     * @return In
     */
    public static function validTaxType(): In
    {
        return Rule::in([
            ChannelMapping::TAX_INCLUSIVE,
            ChannelMapping::TAX_EXCLUSIVE,
        ]);
    }

    /**
     * @return In
     */
    public static function validMarkupType(): In
    {
        return Rule::in([
            ChannelMapping::MARKUP_TYPE_PERCENTAGE,
            ChannelMapping::MARKUP_TYPE_FLAT,
        ]);
    }

    /**
     * @return In
     */
    public static function validRateType(): In
    {
        return Rule::in([
            ChannelMapping::RATE_TYPE_NET,
            ChannelMapping::RATE_TYPE_SELL,
        ]);
    }
}
