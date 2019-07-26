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

    public function hasAbilities(){
        return $this->belongsToMany('FeIron\Fe_Roles\models\fe_abilities', 'fe_role_abilities', 'role_id', 'ability_id');
    }

    public function user()
    {
        //morphedByMany(string $related, string $name, string $table = null, string $foreignPivotKey = null, string $relatedPivotKey = null, string $parentKey = null, string $relatedKey = null)
        return $this->morphedByMany(config('Fe_Roles.appconfig.target_user_model')??'App\User', 'target','fe_role_targets','role_id');
    }
    
}
