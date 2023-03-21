<?php

namespace SYSOTEL\OTA\Common\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AssignGuard
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
        if($guard != null) {
            auth()->shouldUse($guard);
        }

        return $next($request);
    }
}
