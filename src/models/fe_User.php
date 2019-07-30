<?php

namespace FeIron\Fe_Roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_User extends \FeIron\Fe_Login\models\fe_users
{
    // (string $related, string $name, string $table = null, string $foreignKey = null, string $otherKey = null)
    public function Roles()
    {
        return $this->morphToMany('FeIron\Fe_Roles\models\fe_roles', 'target', 'fe_role_targets', 'target_id', 'role_id')
            ->get()
            ->pluck('name', 'id')
            ->all();
    }

    public function MyRoles(){
        return $this->morphToMany('FeIron\Fe_Roles\models\fe_roles', 'target','fe_role_targets', 'target_id','role_id');
    }    

    public function abilities(){
        return $this->RoleAbilities()->load('none_role_abilities');
    }

    public function none_role_abilities()
    {
        return $this->morphToMany('FeIron\Fe_Roles\models\fe_abilities', 'target', 'fe_abilities_targets', 'target_id', 'ability_id')
                    ->get()
                    ->pluck('name', 'id')
                    ->all();
    }

    public function RoleAbilities(){
        return $this->load(['MyRoles.RoleAbilities'])->MyRoles->map(function ($role) {
            return $role->RoleAbilities()
            ->pluck('name', 'id')->map(function($item,$key){
                return [(string)$key=>(string)$item];
            });
        });
    }
}
