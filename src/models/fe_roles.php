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

    public function assignedTo(){//use morph later
        return $this->hasMany('fe_role_targets', 'role_id', 'id');
    }

    public function hasAbilities(){
        $this->belongsToMany('fe_abilities', 'fe_role_abilities', 'role_id', 'ability_id');
    }

    
    
}
