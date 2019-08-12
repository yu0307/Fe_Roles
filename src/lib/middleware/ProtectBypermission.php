<?php

namespace feiron\fe_roles\lib\middleware;

use Closure;
use feiron\fe_roles\exceptions\fe_rolesExceptions;
use Illuminate\Support\Facades\Route;

class ProtectBypermission
{
    public function handle($request, Closure $next, $permission)
    {
        if (is_null($request->user())) { //User not logged in
            if (Route::has('fe_loginWindow'))
                return redirect()->route('fe_loginWindow');
            elseif (Route::has('login'))
                return redirect()->route('login');
            else
                throw fe_permissionsExceptions::notLoggedIn();
        }
        $permissions = is_array($permission) ? $permission : explode('|', $permission);

        if (!$request->user()->UserCan($permissions)) { //User has no permission 
            throw fe_rolesExceptions::UnAuthorized('Permission');
        }
        
        return $next($request);
    }
}
