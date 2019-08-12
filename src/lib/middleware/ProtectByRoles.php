<?php

namespace feiron\fe_roles\lib\middleware;

use Closure;
use feiron\fe_roles\exceptions\fe_rolesExceptions;
use Illuminate\Support\Facades\Route;
class ProtectByRoles
{
    public function handle($request, Closure $next, $role)
    {
        if (is_null($request->user())) {//User not logged in
            if (Route::has('fe_loginWindow'))
                return redirect()->route('fe_loginWindow');
            elseif(Route::has('login'))
                return redirect()->route('login');
            else
                throw fe_rolesExceptions::notLoggedIn();
        }
        $roles = is_array($role) ? $role : explode('|', $role);

        if (!$request->user()->HasRole($roles)) {//User has no role 
            // if (Route::has('fe_loginWindow'))
            //     return redirect()->route('fe_loginWindow');
            // elseif (Route::has('login'))
            //     return redirect()->route('login');
            // else
                throw fe_rolesExceptions::UnAuthorized('Roles');
        }
        return $next($request);
    }
}
