<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Exceptions\Http\AuthenticationException;
use Modules\User\Entities\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next , $permission)
    {
        /** @var User $user */
        $user = Auth::user();
        if($user == null)
            throw new AuthenticationException(
            'Unauthenticated.',
            );
        if($user->role->hasPermission($permission)) {
            return $next($request);
        }else{
            throw new AuthenticationException(
                'Unauthenticated.',
            );
        }
    }
}
