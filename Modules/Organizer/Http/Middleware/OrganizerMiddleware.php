<?php

namespace Modules\Organizer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Exceptions\Http\AuthenticationException;
use Modules\User\Enum\UserType;

class OrganizerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->role->name == UserType::ORGANIZER->value) {
            return $next($request);
        }
        else
            throw new AuthenticationException(
                'Unauthenticated.',

            );
    }
}
