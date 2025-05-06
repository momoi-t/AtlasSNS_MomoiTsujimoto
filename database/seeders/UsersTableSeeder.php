<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            ['username' => 'Atlas一郎',
             'email' => 'Atlas_1@gmail.com',
              'password' => bcrypt('Atlas1')],
            ['username' => 'Atlas二郎',
             'email' => 'Atlas_2@gmail.com',
             'password' => bcrypt('Atlas2')],
            ['username' => 'Atlas三郎',
             'email' => 'Atlas_3@gmail.com',
             'password' => bcrypt('Atlas3')],
        ]);

    }
}
