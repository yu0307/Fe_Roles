<?php

namespace FeIron\Fe_Roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_roles extends Model
{
    protected $table = 'fe_roles';
    protected $attributes = [
        'disabled' => false,
    ];
    protected $fillable = ['name', 'description','rank', 'disabled'];

    public function RoleAbilities(){
        return $this->belongsToMany('FeIron\Fe_Roles\models\fe_abilities', 'fe_role_abilities', 'role_id', 'ability_id');
    }

    public function withAbilities(){
        return $this->where('rank','>=', $this->rank)->get()->map(function($role){
            return $role->RoleAbilities;
        });
    }

    public function Abilities(){
        return $this->withAbilities()->flatten()->pluck('name','id');
    }


    public function User()
    {
        // (string $related, string $name, string $table = null, string $foreignKey = null, string $otherKey = null, bool $inverse = false)
        return $this->morphedByMany('FeIron\Fe_Roles\models\fe_User', 'target','fe_role_targets','role_id','target_id');
    }

}
