<?php

namespace feiron\fe_roles\exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class fe_rolesExceptions extends HttpException
{
    
    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }

    public static function UnAuthorized($type='permission'): self
    {
        return new static(403, 'User needs acceptable '. $type.' to proceed.', null, []);
    }
}


?>