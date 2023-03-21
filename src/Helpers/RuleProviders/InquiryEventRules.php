<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Inquiry\InquiryEvent;

class InquiryEventRules extends UserRules
{
    /**
     * @return In
     */
    public static function validStatus(): In
    {
        return new In([
            InquiryEvent::STATUS_OPEN,
            InquiryEvent::STATUS_CLOSED
        ]);
    }

    /**
     * @return In
     */
    public static function validTyps(): In
    {
        return new In([
            InquiryEvent::TYPE_ADMIN_UPDATE,
            InquiryEvent::TYPE_CREATION,
        ]);
    }
}
