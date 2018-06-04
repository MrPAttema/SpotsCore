<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        'firstname' => 'Patrick',
        'lastname' => 'Attema',
        'email' => 'patrickattema@home.nl',
        'password' => bcrypt('Halo3iscool!'),
      ]);
    }
}
