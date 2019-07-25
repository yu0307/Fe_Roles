<?php

namespace FeIron\Fe_Roles\database\seeder;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Fe_roles_seeder::class);
        $this->call(Fe_abilities_seeder::class);
        $this->call(Fe_role_abilities_seeder::class);
        $this->call(Fe_role_targets_seeder::class);//remove on production
        $this->call(Fe_abilities_targets_seeder::class);//remove on production
        
    }
}
