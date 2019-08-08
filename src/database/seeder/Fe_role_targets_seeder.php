<?php

namespace \fe_roles\database\seeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Fe_role_targets_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fe_role_targets')->insert([
            ['role_id' => rand(1, 4), 'target_id' => 1, 'target_type'=>'user'],
            ['role_id' => rand(1, 4), 'target_id' => 2, 'target_type'=>'user'],
            ['role_id' => rand(1, 4), 'target_id' => 3, 'target_type'=>'user'],
        ]);

    }
}
