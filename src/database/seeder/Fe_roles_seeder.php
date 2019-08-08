<?php

namespace \fe_roles\database\seeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Fe_roles_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fe_roles')->insert([
            ['name' => 'admin', 'description' => "Site Administrator", 'rank'=>1],
            ['name' => 'editor', 'description' => "post editors", 'rank' => 2],
            ['name' => 'subscriber', 'description' => "subscribers", 'rank' => 3],
            ['name' => 'guest', 'description' => "guests", 'rank' => 4],
        ]);

    }
}
