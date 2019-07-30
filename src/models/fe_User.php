<?php

namespace FeIron\Fe_Roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_User extends \FeIron\Fe_Login\models\fe_users
{
        // (string $related, string $name, string $table = null, string $foreignKey = null, string $otherKey = null)
        public function Roles(){
            return $this->morphToMany('FeIron\Fe_Roles\models\fe_roles', 'target','fe_role_targets','target_id','role_id');
        }

        public function abilities(){
            return $this->load('Roles')->Roles->map(function($role){
                return $role->Abilities();
            })->flatten()->pluck('name','id');
        }

        public function RoleAbilities(){
            return $this->load('Roles.RankAbilities')->Roles->map(function($role){
                return $role->RankAbilities;
            })->flatten()->pluck('name','id');
        }

}
