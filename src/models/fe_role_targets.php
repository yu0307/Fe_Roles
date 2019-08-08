<?php

namespace \fe_roles\models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class fe_role_targets extends MorphPivot
{

    protected $table = 'fe_role_targets';
    protected $primaryKey = ['role_id', 'target_id', 'target_type'];
    public $incrementing = false;
    protected $attributes = [
        'disabled' => false,
    ];
    protected $fillable = ['role_id', 'target_id', 'target_type', 'disabled'];    
}
