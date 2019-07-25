<?php

namespace FeIron\Fe_Roles\database\seeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Fe_role_abilities_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fe_role_abilities')->insert([
            ['role_id' => 4, 'ability_id' => 1],
            ['role_id' => 3, 'ability_id' => 2],
            ['role_id' => 2, 'ability_id' => 3],            
            ['role_id' => 2, 'ability_id' => 5],
            ['role_id' => 2, 'ability_id' => 6],
            ['role_id' => 1, 'ability_id' => 4]
        ]);
    }
}
