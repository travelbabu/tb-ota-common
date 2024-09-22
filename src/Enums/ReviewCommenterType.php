<?php

namespace SYSOTEL\OTA\Common\Enums;

use function SYSOTEL\OTA\Common\Helpers\readableConstant;

enum ReviewCommenterType: string
{
    case GUEST = 'GUEST';
    case EXTRANET_USER = 'EXTRANET_USER';
    case ADMIN = 'ADMIN';
    case UNKNOWN = 'UNKNOWN';

    /**
     * @return string
     */
    public function label(): string
    {
        return readableConstant($this->value);
    }
}