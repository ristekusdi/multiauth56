<?php

use Illuminate\Database\Seeder;

class WritersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Writer::create([
            'name'    => 'Azrul Ananda',
            'email'    => 'azrul@ananda.com',
            'password' => bcrypt('secret')
        ]);
    }
}
