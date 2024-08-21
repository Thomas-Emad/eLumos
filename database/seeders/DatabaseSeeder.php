<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            TagsSeeder::class,
            LanguagesTableSeeder::class
        ]);

        $user =   User::factory()->create([
            'name' => 'Thomas Emad',
            'email' => 'elumos@gmail.com',
            'password' => Hash::make('123456')
        ]);

        $user->assignRole([1]); // default role is owner also it first one created in db his id is 1
    }
}
