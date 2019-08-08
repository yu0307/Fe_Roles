<?php

namespace \fe_roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_role_abilities extends Model
{

    protected $table = 'fe_role_abilities';
    protected $primaryKey = ['role_id', 'ability_id'];
    public $incrementing = false;
    protected $attributes = [
        'disabled' => false,
    ];
    protected $fillable = ['role_id', 'ability_id', 'disabled'];

    
}
