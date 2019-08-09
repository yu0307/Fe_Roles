<?php

namespace feiron\fe_roles\lib\guard;

class fe_role_guard 
extends \Illuminate\Auth\SessionGuard
{
    protected $request;
    protected $provider;
    protected $user;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->request = $request;
        $this->provider = $provider;
        $this->user = NULL;
    }

    /**
     * Validate a user's credentials.
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials[(config('fe_roles_appconfig.user_name_field') ?? 'email')]) || empty($credentials[(config('fe_roles_appconfig.user_name_field') ?? 'password')])) {
            return false;
        }

        $user = $this->provider->retrieveByCredentials($credentials);

        if (!is_null($user) && $this->provider->validateCredentials($user, $credentials)) {
            $this->setUser($user);
            return true;
        } else {
            return false;
        }
    }
}
