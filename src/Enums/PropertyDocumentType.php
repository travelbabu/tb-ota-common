<?php

namespace SYSOTEL\OTA\Common\Enums;

use function SYSOTEL\OTA\Common\Helpers\readableConstant;

enum PropertyDocumentType: string
{
    case AADHAAR = 'AADHAAR';
    case BANK_DETAILS = 'BANK_DETAILS';
    case PAN = 'PAN';
    case GST = 'GST';
    case NO_GST_DECLARATION = 'NO_GST_DECLARATION';
    case NO_OBJECTION_CERTIFICATE = 'NO_OBJECTION_CERTIFICATE';
    case TRADE_LICENCE = 'TRADE_LICENCE';
    case LEASE_CONTRACT = 'LEASE_CONTRACT';
    case PROPERTY_OWNERSHIP_CERTIFICATE = 'PROPERTY_OWNERSHIP_CERTIFICATE';
    case MSME_CERTIFICATE = 'MSME_CERTIFICATE';

    /**
     * @return string
     */
    public function label(): string
    {
        return readableConstant($this->value);
    }
}