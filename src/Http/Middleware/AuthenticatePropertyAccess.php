<?php

namespace SYSOTEL\OTA\Common\Http\Middleware;

use Closure;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Illuminate\Http\Request;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;

/**
 * This middleware should be used with authenticated routes
 * It assumes that $request->user() will return logged in user
*/
class AuthenticatePropertyAccess
{
    /**
     * @var string
     */
    protected $routeParamName = 'propertyID';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     * @throws LockException
     * @throws MappingException
     */
    public function handle(Request $request, Closure $next, string $guard = null): mixed
    {
        $user = $request->user();
        $propertyID = $request->route($this->routeParamName);

        /** @var Property $property */
        $property = Property::repository()->find($propertyID);

        if(! $property || ! $property->hasUserReference($user)) {
            abort(404);
        }

        Request::macro('requestProperty', function() use($property){
            return $property;
        });

        return $next($request);
    }
}
