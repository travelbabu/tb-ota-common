<?php

namespace SYSOTEL\OTA\Common\Http\Request;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Guest;

/**
 * This method is added using macro using UserProvider middleware
 * @method OTAUser requestUser()
 */
abstract class UserRequest extends BaseRequest {}
