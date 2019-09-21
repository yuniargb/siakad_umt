<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name'  => 'admin',
            'role' => 4,
            'username' => 'superadmin',
            'password'  => Hash::make('admin')
        ]);
    }
}
