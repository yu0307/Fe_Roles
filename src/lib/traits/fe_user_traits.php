<?php
namespace feiron\fe_roles\lib\traits;

trait fe_user_traits{
    // (string $related, string $name, string $table = null, string $foreignKey = null, string $otherKey = null)
    public function Roles()
    {
        return $this->morphToMany('\feiron\fe_roles\models\fe_roles', 'target', 'fe_role_targets', 'target_id', 'role_id');
    }

    public function abilities()
    {
        return $this->RoleAbilities()->union($this->None_Role_Abilities());
    }

    public function RoleAbilities()
    {
        return $this->load('Roles')->Roles->map(function ($role) {
            return $role->withAbilities();
        })->flatten()->pluck('name', 'id');
    }

    public function None_Role_Abilities()
    {
        return $this->morphToMany('\feiron\fe_roles\models\fe_abilities', 'target', 'fe_abilities_targets', 'target_id', 'ability_id')
            ->get()
            ->pluck('name', 'id');
    }

    public function HasRole($roleName){
        return $this->Roles->pluck('name')->contains($roleName);
    }

    public function UserCan($abilityName){
        return $this->abilities()->contains($abilityName);
    }
}
?>