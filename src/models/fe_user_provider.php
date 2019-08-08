<?php
namespace feiron\fe_roles\models;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class fe_user_provider implements UserProvider
{
    private $usrModel;
    private $userNameField = 'email';
    private $userPasswordField = 'password';
    private $rememberTokenName = 'remember_token';

    /**
     * Create a new user provider.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * @return void
     */
    public function __construct(Illuminate\Contracts\Auth\Authenticatable $userModel)
    {
        $this->usrModel = $userModel;
        $this->userNameField = (config('fe_roles.appconfig.user_name_field') ?? $this->userNameField);
        $this->userPasswordField = (config('fe_roles.appconfig.user_password_field') ?? $this->userPasswordField);
        $this->rememberTokenName = (config('fe_roles.appconfig.user_remember_token_field') ?? $this->rememberTokenName);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return;
        }
        return $this->usrModel->fetchUserByCredentials($credentials);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials  Request credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials[$this->userPasswordField];
        return app('hash')->check($plain, $user->getAuthPassword());
    }

    public function retrieveById($identifier)
    {
        return $this->user->find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    { 
        return $this->fetchUserByToken($identifier, $token);
    }

    public function updateRememberToken(Authenticatable $user, $token)
    { 
        $user->setRememberToken($token);
    }
}
