<?php

namespace FeIron\Fe_Roles\models;

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

    public function user()
    {
        // return $this->belongsTo('FeIron\Fe_Roles\models\fe_User');
        return $this->morphedByMany('FeIron\Fe_Roles\models\fe_User', 'target', 'fe_role_targets', 'role_id', 'target_id');
    }

    public function roles()
    {
        return $this->belongsTo('FeIron\Fe_Roles\models\fe_roles', 'role_id');
    }

    public function abilities()
    {
        return $this->hasManyThrough('FeIron\Fe_Roles\models\fe_abilities', 'FeIron\Fe_Roles\models\fe_roles');
    }
    
}
