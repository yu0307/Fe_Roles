<?php
namespace feiron\fe_roles\lib\traits;

trait fe_user_traits{
    // (string $related, string $name, string $table = null, string $foreignKey = null, string $otherKey = null)
    public function Roles()
    {
        return $this->morphToMany('\feiron\fe_roles\models\fe_roles', 'target', 'fe_role_targets', 'target_id', 'role_id');
    }

    public function Groups()
    {
        return $this->morphToMany('\feiron\fe_roles\models\fe_groups', 'target', 'fe_group_targets', 'target_id', 'group_id');
    }

    public function abilities()
    {
        return $this->RoleAbilities()->union($this->None_Role_Abilities())->union($this->GroupAbilities());
    }

    public function RoleAbilities()
    {
        return $this->load('Roles')->Roles->map(function ($role) {
            return $role->withAbilities();
        })->flatten()->pluck('name', 'id');
    }

    public function GroupAbilities(){
        return $this->Groups->map(function ($group) {
            return $group->withAbilities();
        })->flatten()->pluck('name', 'id');
    }

    public function None_Role_Abilities()
    {
        return $this->morphToMany('\feiron\fe_roles\models\fe_abilities', 'target', 'fe_abilities_targets', 'target_id', 'ability_id')
            ->get()
            ->pluck('name', 'id');
    }

    public function FromGroup($groupIdentifier = []){
        $groupIdentifier = is_array($groupIdentifier) ? $groupIdentifier : [$groupIdentifier];
        return $this->Groups->pluck((is_numeric($groupIdentifier)?'id': 'name'))->contains(function ($value, $key) use ($groupIdentifier) {
            return in_array($value, $groupIdentifier);
        });
    }

    public function HasRole($roleName=[]){
        $roleName=is_array($roleName)? $roleName:[$roleName];
        return $this->Roles->pluck('name')->contains(function($value,$key) use ($roleName){
            return in_array($value,$roleName);
        });
    }

    public function UserCan($abilityName){
        $abilities = is_array($abilityName) ? $abilityName : [$abilityName];
        return $this->abilities()->contains(function ($value, $key) use ($abilities) {
            return in_array($value, $abilities);
        });
    }
}
?>