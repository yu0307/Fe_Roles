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

        }

        public function rb(){
            return $this->load('Roles.Abilities');
        }

        public function RoleAbilities(){
            
            return $abilities= $this->load('Roles.Abilities')->Roles->map(function($role){
                return $role->Abilities;
            })->flatten()->pluck('name','id');

            $abilities->each;
            // return $this->load('Roles.Abilities')->Roles->map(function($role){
            //     return $role->Abilities->pluck('name','id')->all();
            // });


            // return $this->load('Roles.Abilities');
            // return array_map(
            //                 function($role){
            //                     return $role->Abilities;
            //                 },
            //                 $this->load('Roles.Abilities')->Roles->all()
            //                 );
        }

}
