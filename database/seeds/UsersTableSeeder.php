<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'    => 'Tina',
            'email'    => 'tina@toon.com',
            'password' => bcrypt('secret')
        ]);
    }
}
