<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'password' => Hash::make('admin'),
            'username' => 'admin',
            'role' => '1',
            'departement' => '1',
            'phone' => '0',
            'ktpaddress' => 'Madiun',

        ]);
    }
}
