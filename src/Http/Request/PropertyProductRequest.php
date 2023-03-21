<?php

namespace SYSOTEL\OTA\Common\Http\Request;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct;

/**
 * This method is added by AuthenticatePropertyProduct middleware
 * @method PropertyProduct requestProduct()
 */
abstract class PropertyProductRequest extends PropertyRequest {}
