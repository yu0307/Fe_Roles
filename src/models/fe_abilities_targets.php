<?php

namespace \fe_roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_abilities_targets extends Model
{

    protected $table = 'fe_abilities_targets';
    protected $primaryKey = ['ability_id', 'target_id', 'target_type'];
    public $incrementing = false;
    protected $attributes = [
        'disabled' => false,
    ];
    protected $fillable = ['ability_id', 'target_id', 'target_type', 'disabled'];
}
