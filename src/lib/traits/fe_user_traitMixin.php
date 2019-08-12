<?php

namespace feiron\fe_roles\lib\traits;

class fe_user_traitMixin
{
    public function Roles()
    {
        return function () {
            return $this->morphToMany('\feiron\fe_roles\models\fe_roles', 'target', 'fe_role_targets', 'target_id', 'role_id');
        };
    }

    public function abilities()
    {
        return function () {
            return $this->RoleAbilities()->union($this->None_Role_Abilities());
        };
    }

    public function RoleAbilities()
    {
        return function () {
            return $this->load('Roles')->Roles->map(function ($role) {
                return $role->withAbilities();
            })->flatten()->pluck('name', 'id');
        };
    }

    public function None_Role_Abilities()
    {
        return function () {
            return $this->morphToMany('\feiron\fe_roles\models\fe_abilities', 'target', 'fe_abilities_targets', 'target_id', 'ability_id')
                ->get()
                ->pluck('name', 'id');
        };
    }

    public function HasRole()
    {
        return function ($roleName) {
            return $this->Roles->pluck('name')->contains($roleName);
        };
    }

    public function UserCan()
    {
        return function ($abilityName) {
            return $this->abilities()->contains($abilityName);
        };
    }
}

?>