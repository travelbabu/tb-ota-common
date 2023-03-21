<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\User;

use Illuminate\Support\Facades\Hash;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Password;

trait HasPassword
{
    /**
     * Sets hashed password
     *
     * @param string $password
     * @return string
     * @author Ravish
     */
    public function setPassword(string $password): string
    {
        return $this->password = (new Password())->setPassword($password);
    }

    /**
     * Sets hashed password
     *
     * @param string $password
     * @return bool
     * @author Ravish
     */
    public function validatePassword(string $password): bool
    {
        return $this->password->validate($password);
    }
}