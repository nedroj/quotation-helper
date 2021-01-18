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
            'email'    => 'jorden@doitonlinemedia.nl',
            'password' => \Hash::make('password'),
        ]);
    }
}
