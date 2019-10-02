<?php

namespace feiron\fe_roles\models;

use Illuminate\Database\Eloquent\Model;

class fe_groups extends Model
{
    protected $table = 'fe_groups';
    protected $attributes = [
        'disabled' => false,
    ];
    protected $fillable = ['name', 'description', 'disabled'];

    public function user()
    {
        //morphedByMany(string $related, string $name, string $table = null, string $foreignPivotKey = null, string $relatedPivotKey = null, string $parentKey = null, string $relatedKey = null)
        return $this->morphedByMany('\feiron\fe_roles\models\fe_User', 'target', 'fe_group_targets', 'group_id', 'target_id');
    }
    public function role()
    {
        //morphedByMany(string $related, string $name, string $table = null, string $foreignPivotKey = null, string $relatedPivotKey = null, string $parentKey = null, string $relatedKey = null)
        return $this->morphedByMany('\feiron\fe_roles\models\fe_roles', 'target', 'fe_group_targets', 'group_id', 'target_id');
    }
    public function abilities()
    {
        //morphedByMany(string $related, string $name, string $table = null, string $foreignPivotKey = null, string $relatedPivotKey = null, string $parentKey = null, string $relatedKey = null)
        return $this->morphedByMany('\feiron\fe_roles\models\fe_abilities', 'target', 'fe_group_targets', 'group_id', 'target_id');
    }
    public function withAbilities()
    {
        return $this->abilities()->get();
    }
}
