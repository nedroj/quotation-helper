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
            'name'     => 'jorden hesse',
            'email'    => 'jordenhesse@hotmail.com',
            'password' => \Hash::make('password'),
        ]);
    }
}
