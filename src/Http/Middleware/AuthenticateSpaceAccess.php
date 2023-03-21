<?php

namespace SYSOTEL\OTA\Common\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;

/**
 * This middleware must be chained after AuthenticatePropertyAccess middleware
 */
class AuthenticateSpaceAccess
{
    /**
     * @var string
     */
    protected $routeParamName = 'spaceID';

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

        $propertySpaceID = $request->route($this->routeParamName);

        /** @var PropertySpace $propertySpace */
        $propertySpace = PropertySpace::repository()->findOneBy([
            '_id' => $propertySpaceID,
            'propertyID' => $property->id,
        ]);

        if(! $propertySpace) {
            abort(404);
        }

        Request::macro('requestSpace', function() use($propertySpace){
            return $propertySpace;
        });

        return $next($request);
    }
}
