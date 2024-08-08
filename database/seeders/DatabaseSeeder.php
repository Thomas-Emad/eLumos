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
            PermissionTableSeeder::class
        ]);

        $user =   User::factory()->create([
            'name' => 'Thomas Emad',
            'email' => 'elumos@gmail.com',
            'password' => Hash::make('123456')
        ]);

        $role = Role::create(['name' => 'owner']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
