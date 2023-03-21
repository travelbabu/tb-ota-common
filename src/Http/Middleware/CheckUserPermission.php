<?php

namespace SYSOTEL\OTA\Common\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use SYSOTEL\OTA\Common\Services\IAM\Facades\IAM;

class CheckUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string $permission
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $permission): Response|RedirectResponse
    {
        $user = $this->user($request);

        if( ! IAM::can($permission, $user)) {
            abort(401);
        }

        return $next($request);
    }

    /**
     * @param Request $request
     * @return User
     */
    protected function user(Request $request): User
    {
        return $request->user();
    }
}
