<?php

namespace SYSOTEL\OTA\Common\Http\Request;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;

/**
 * This method is added by AuthenticateSpaceAccess middleware
 * @method PropertySpace requestSpace()
 */
abstract class PropertySpaceRequest extends PropertyRequest {}
