<?php

namespace SYSOTEL\OTA\Common\Http\Request;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Guest;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

/**
 * These methods are added using macro using PropertyProvider and UserProvider middlewares
 * @method User requestUser()
 * @method Property requestProperty()
 */
abstract class PropertyRequest extends BaseRequest {}
