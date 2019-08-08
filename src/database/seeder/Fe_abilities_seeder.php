<?php

namespace feiron\fe_roles\database\seeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Fe_abilities_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fe_abilities')->insert([
            ['name' => 'read','description' => "view other's post"],
            ['name' => 'viewprofile', 'description' => "view other's profile page"],
            ['name' => 'post', 'description' => 'submit a post'],
            ['name' => 'admin', 'description' => 'view admin page'],
            ['name' => 'edit', 'description' => 'edit post'],
            ['name' => 'delete', 'description' => 'delete post']
        ]);
    }
}
