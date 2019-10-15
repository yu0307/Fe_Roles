<?php

namespace feiron\fe_roles\lib\middleware;

use Closure;
use feiron\fe_roles\exceptions\fe_rolesExceptions;
use Illuminate\Support\Facades\Route;

class ProtectByGroup
{
    public function handle($request, Closure $next, $groups)
    {
        if (is_null($request->user())) { //User not logged in
            if (Route::has('fe_loginWindow'))
                return redirect()->route('fe_loginWindow');
            elseif (Route::has('login'))
                return redirect()->route('login');
            else
                throw fe_permissionsExceptions::notLoggedIn();
        }
        $groups = is_array($groups) ? $groups : explode('|', $groups);

        if (!$request->user()->FromGroup($groups)) { //User has no permission 
            throw fe_rolesExceptions::UnAuthorized('Group');
        }

        return $next($request);
    }
}
