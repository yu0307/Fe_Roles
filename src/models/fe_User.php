<?php

namespace FeIron\Fe_Roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_User extends Model
{
    protected $table = 'users2';

    public function Roles()
    {
        $this->setTable(config('Fe_Roles.appconfig.target_user_model') ?? 'users');
        $this->setKeyName((config('fe_roles_appconfig.primary_Key') ?? 'id'));

        //morphToMany(string $related, string $name, string $table = null, string $foreignPivotKey = null, string $relatedPivotKey = null, string $parentKey = null, string $relatedKey = null, bool $inverse = false)
        return $this->morphToMany('FeIron\Fe_Roles\models\fe_roles', 'target','fe_role_targets','role_id','id');
    }
    
}
