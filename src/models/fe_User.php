<?php

namespace FeIron\Fe_Roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_User extends Model
{
    protected $table = 'users';
    protected $userModel;

    //config('fe_roles_appconfig.target_user_model') typed $user
    public function __construct($user=null)
    {
        // $this->userModel = config('fe_roles_appconfig.target_user_model') ?? 'App\User';
        // if(isset($this->userModel) && class_exists($this->userModel) ){
        if(isset($user)){
            $this->setTable($user->getTable());
            $this->userModel = $user;
        }else{
            $this->userModel = config('fe_roles_appconfig.target_user_model') ?? 'App\User';
            
        }
                
        // }
    }

    
    
}
