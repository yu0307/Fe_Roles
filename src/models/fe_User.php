<?php

namespace FeIron\Fe_Roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_User extends \FeIron\Fe_Login\models\fe_users
{
        // (string $related, string $name, string $table = null, string $foreignKey = null, string $otherKey = null)
        public function roles(){
            return $this->morphToMany('FeIron\Fe_Roles\models\fe_roles', 'target','fe_role_targets','role_id','role_id');
        }

        public function abilities(){

        }
}
