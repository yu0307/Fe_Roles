<?php

namespace FeIron\Fe_Roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_role_targets extends Model
{

    protected $table = 'fe_role_targets';
    protected $primaryKey = ['role_id', 'target_id', 'target_type'];
    public $incrementing = false;
    protected $attributes = [
        'disabled' => false,
    ];
    protected $userModel='App\User';
    protected $fillable = ['role_id', 'target_id', 'target_type', 'disabled'];

    public function __construct(){
        $this->userModel= config('fe_roles_appconfig.target_user_model')?? 'App\User';
    }
    
}
