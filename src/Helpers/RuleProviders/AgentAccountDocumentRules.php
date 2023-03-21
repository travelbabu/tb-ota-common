<?php

namespace SYSOTEL\OTA\Common\Helpers\RuleProviders;

use Illuminate\Validation\Rules\In;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccountDocument\AgentAccountDocument;

class AgentAccountDocumentRules extends UserRules
{
    public static function validDocType(): In
    {
        return new In([
            AgentAccountDocument::DOC_TYPE_BANK,
            AgentAccountDocument::DOC_TYPE_GST,
            AgentAccountDocument::DOC_TYPE_PAN,
            AgentAccountDocument::DOC_TYPE_IATA,
            AgentAccountDocument::DOC_TYPE_TAN,
            AgentAccountDocument::DOC_TYPE_ITR,
        ]);
    }
}
