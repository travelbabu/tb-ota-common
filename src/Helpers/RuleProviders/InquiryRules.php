<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Inquiry\Inquiry;

class InquiryRules extends UserRules
{
    /**
     * @return In
     */
    public static function validStatus(): In
    {
        return new In([
            Inquiry::STATUS_OPEN,
            Inquiry::STATUS_CLOSED
        ]);
    }

    /**
     * @return In
     */
    public static function validType(): In
    {
        return new In([
            Inquiry::TYPE_GENERAL,
            Inquiry::TYPE_B2B
        ]);
    }

    /**
     * @return In
     */
    public static function validSource(): In
    {
        return new In([
            Inquiry::SOURCE_CONTACT_US,
        ]);
    }
}
