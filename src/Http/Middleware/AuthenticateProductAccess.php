<?php

namespace SYSOTEL\OTA\Common\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct;

/**
 * This middleware must be chained after AuthenticatePropertyAccess middleware
 */
class AuthenticateProductAccess
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $guard = null): mixed
    {
        $property = $request->requestProperty();

        $productID = $request->route('productID');

        /** @var PropertyProduct $propertyProduct */
        $propertyProduct = PropertyProduct::repository()->findOneBy([
            '_id' => (int) $productID,
            'propertyID' => $property->id,
        ]);

        if(! $propertyProduct) {
            abort(404);
        }

        Request::macro('requestProduct', function() use($propertyProduct){
            return $propertyProduct;
        });

        return $next($request);
    }
}
