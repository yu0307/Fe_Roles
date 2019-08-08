<?php

namespace feiron\fe_roles\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use feiron\fe_roles\models\fe_user_traits;

class fe_User 
extends  \feiron\fe_login\models\fe_users
implements AuthenticatableContract
{
    use fe_user_traits;

    private $userNameField='id';
    private $userPasswordField = 'password';
    protected $rememberTokenName= 'remember_token';
    private $usrName;
    private $usrPass;
    private $token;

    public function __construct()
    {
        $this->userNameField=(config('fe_roles.appconfig.user_name_field')?? $this->userNameField);
        $this->userPasswordField = (config('fe_roles.appconfig.user_password_field') ?? $this->userPasswordField);
        $this->rememberTokenName = (config('fe_roles.appconfig.user_remember_token_field') ?? $this->rememberTokenName);
    }

    /**
     * Fetch user by Credentials
     *
     * @param array $credentials
     * @return Illuminate\Contracts\Auth\Authenticatable
     */
    public function fetchUserByCredentials(array $credentials)
    {
        return $this->where([ $this->userNameField => $credentials[$this->userNameField]])->first();
    }

    /**
     * Fetch user by Token
     *
     * @param array $Token
     * @return Illuminate\Contracts\Auth\Authenticatable
     */
    public function fetchUserByToken($identifier,$Token)
    {
        return  $this->where([$this->getAuthIdentifierName() => $identifier,$this->getRememberTokenName()=> $Token])->first();
    }

    public function getAuthIdentifierName()
    {
        return $this->userNameField;
    }

    public function getAuthIdentifier()
    {
        return $this->usrName;
    }

    public function getAuthPassword()
    {
        return $this->usrPass;
    }

    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }

    public function setRememberToken($value)
    {
        $this->token = $value;
    }

    public function getRememberToken()
    {
        return $this->token;
    }
}
