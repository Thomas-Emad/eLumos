<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Create owner User
    $owner =   User::factory()->create([
      'name' => 'Thomas Emad, owner',
      'email' => 'elumos@gmail.com',
      'password' => Hash::make('123456')
    ]);
    $owner->assignRole([1]); // default role is owner also it first one created in db his id is 1

    // Create instructor User
    $instructor =  User::factory()->create([
      'name' => 'Thomas Emad, instructor',
      'email' => 'instructor@gmail.com',
      'password' => Hash::make('123456')
    ]);
    $instructor->assignRole([2]);

    // Create Student User
    $student =  User::factory()->create([
      'name' => 'Thomas Emad, student',
      'email' => 'student@gmail.com',
      'password' => Hash::make('123456')
    ]);
    $student->assignRole([3]);
  }
}
