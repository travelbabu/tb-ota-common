<?php

namespace SYSOTEL\OTA\Common\Services\StorageServices;

class PropertyPrivateStorage extends StorageManager
{
    public function isPublicVisibility(): bool
    {
        return false;
    }
}
