<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
      'name' => 'SDM',
      'password' => Hash::make('admin'),
      'username' => 'admin',
      'role' => '1',
      'id_department' => '1',
      'phone' => '0',
      'ktpaddress' => 'Madiun',
      'image' => '',
      'job'=> '',
    ]);

    DB::table('users')->insert([
      'name' => 'Kadiv',
      'password' => Hash::make('admind'),
      'username' => 'admind',
      'role' => '2',
      'id_department' => '1',
      'phone' => '0',
      'ktpaddress' => 'Madiun',
      'image' => '',
      'job'=> '',
    ]);

    DB::table('users')->insert([
      'name' => 'User',
      'password' => Hash::make('user'),
      'username' => 'user',
      'role' => '3',
      'id_department' => '1',
      'phone' => '02',
      'ktpaddress' => 'Madiun',
      'image' => '',
      'job'=> '',
    ]);
  }
}
