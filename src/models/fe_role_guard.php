<?php

namespace FeIron\Fe_Roles\models;

class fe_role_guard 
extends \Illuminate\Auth\SessionGuard
{
    // protected $request;
    // protected $provider;
    // protected $user;

    // public function __construct(UserProvider $provider, Request $request)
    // {
    //     $this->request = $request;
    //     $this->provider = $provider;
    //     $this->user = NULL;
    // }
    // /**
    //  * Determine if the current user is authenticated.
    //  *
    //  * @return bool
    //  */
    // public function check()
    // {
    //     return !is_null($this->user());
    // }

    // /**
    //  * Determine if the current user is a guest.
    //  *
    //  * @return bool
    //  */
    // public function guest()
    // {
    //     return !$this->check();
    // }

    // /**
    //  * Get the currently authenticated user.
    //  *
    //  * @return \Illuminate\Contracts\Auth\Authenticatable|null
    //  */
    // public function user()
    // {
    //     if (!is_null($this->user)) {
    //         return $this->user;
    //     }
    // }

    // /**
    //  * Get the ID for the currently authenticated user.
    //  *
    //  * @return string|null
    //  */
    // public function id()
    // {
    //     if (false !== $this->user()) {
    //         return $this->user()->getAuthIdentifier();
    //     }
    // }

    // /**
    //  * Validate a user's credentials.
    //  *
    //  * @return bool
    //  */
    // public function validate(array $credentials = [])
    // {
    //     if (empty($credentials[(config('fe_roles_appconfig.user_name_field') ?? 'email')]) || empty($credentials[(config('fe_roles_appconfig.user_name_field') ?? 'password')])) {
    //         return false;
    //     }

    //     $user = $this->provider->retrieveByCredentials($credentials);

    //     if (!is_null($user) && $this->provider->validateCredentials($user, $credentials)) {
    //         $this->setUser($user);
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // /**
    //  * Set the current user.
    //  *
    //  * @param  Array $user User info
    //  * @return void
    //  */
    // public function setUser(Authenticatable $user)
    // {
    //     $this->user = $user;
    //     return $this;
    // }
}
