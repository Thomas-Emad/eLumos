<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    private array $permissions = [
        'users',
        'roles',
        'control-courses',
        'buy-courses',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $per) {
            Permission::create(['name' => $per]);
        }
    }
}
