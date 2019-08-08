<?php

namespace \fe_roles\database\seeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Fe_abilities_targets_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fe_abilities_targets')->insert([
            ['ability_id' => 1, 'target_id' => "1", 'target_type'=>"user"],
            ['ability_id' => 3, 'target_id' => "1", 'target_type' => "user"],
            ['ability_id' => 4, 'target_id' => "1", 'target_type' => "user"],
            ['ability_id' => 5, 'target_id' => "2", 'target_type' => "user"],
            ['ability_id' => 1, 'target_id' => "2", 'target_type' => "user"],
            ['ability_id' => 2, 'target_id' => "3", 'target_type' => "user"]
        ]);
    }
}
