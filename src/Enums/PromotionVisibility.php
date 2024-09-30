<?php

namespace SYSOTEL\OTA\Common\Enums;

use function SYSOTEL\OTA\Common\Helpers\readableConstant;

enum PromotionVisibility: string
{
    case PUBLIC = 'PUBLIC';
    case HIDDEN = 'HIDDEN';

    /**
     * @return string
     */
    public function label(): string
    {
        return readableConstant($this->value);
    }
}