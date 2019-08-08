<?php
namespace \fe_roles\models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;    

class Fe_RoleChecker implements AuthenticatableContract{

    protected $tarUser;

    public function __construct($user=null)
    {
        $this->tarUser=$user;
    }

    /**
     * Fetch user by Credentials
     *
     * @param array $credentials
     * @return Illuminate\Contracts\Auth\Authenticatable
     */
    public function fetchAbilitiesByCredentials($user=null)
    {
        $this->tarUser= $user??$this->tarUser;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthIdentifierName()
     */
    public function getAuthIdentifierName()
    {
        return $this->tarUser->getAuthIdentifierName();
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthIdentifier()
     */
    public function getAuthIdentifier()
    {
        return $this->tarUser->getAuthIdentifier();
    }
}
?>