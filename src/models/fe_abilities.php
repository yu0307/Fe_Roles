<?php

namespace FeIron\Fe_Roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_abilities extends Model
{
    protected $table = 'fe_abilities';
    protected $attributes = [
        'disabled' => false,
    ];
    protected $fillable = ['name', 'description', 'disabled'];

    public function fromRole(){
        $this->belongsToMany('FeIron\Fe_Roles\models\fe_roles', 'fe_role_abilities', 'ability_id', 'role_id');
    }
}
