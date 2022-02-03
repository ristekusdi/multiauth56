<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Writer::create([
            'name'    => 'Dahlan Iskan',
            'email'    => 'dahlan@iskan.com',
            'password' => bcrypt('secret')
        ]);
    }
}
