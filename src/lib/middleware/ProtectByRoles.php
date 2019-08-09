<?php

namespace feiron\fe_roles\lib\middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use feiron\fe_roles\exceptions\fe_rolesExceptions;
use Illuminate\Support\Facades\Route;
class ProtectByRoles
{
    public function handle($request, Closure $next, $role)
    {
        if (is_null($request->user())) {
            if (Route::has('fe_loginWindow'))
                return redirect()->route('fe_loginWindow');
            elseif(Route::has('login'))
                return redirect()->route('login');
            else
                throw fe_rolesExceptions::notLoggedIn();
        }

        // $roles = is_array($role)
        //     ? $role
        //     : explode('|', $role);

        // if (!Auth::user()->hasAnyRole($roles)) {
        //     throw UnauthorizedException::forRoles($roles);
        // }

        return $next($request);
    }
}
