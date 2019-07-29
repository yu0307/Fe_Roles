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
        return $this->belongsToMany('FeIron\Fe_Roles\models\fe_roles', 'fe_role_abilities', 'ability_id', 'role_id');
    }

    public function user()
    {
        //morphedByMany(string $related, string $name, string $table = null, string $foreignPivotKey = null, string $relatedPivotKey = null, string $parentKey = null, string $relatedKey = null)
        // return $this->morphedByMany(config('Fe_Roles.appconfig.target_user_model')??'App\User', 'target','fe_abilities_targets','ability_id');
        return $this->morphedByMany('FeIron\Fe_Roles\models\fe_User', 'target','fe_abilities_targets','ability_id','target_id');
    }
}
