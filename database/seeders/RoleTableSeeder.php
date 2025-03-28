<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $roles = [
      ['name' => 'owner'],
      ['name' => 'instructor'],
      ['name' => 'support'],
      ['name' => 'student']
    ];

    foreach ($roles as $role) {
      $role = Role::create($role);

      $permissionsAsRole = match ($role->name) {
        'owner' => ['customize-layout', 'users', 'roles', 'admin-control-courses', 'buy-courses', 'support'],
        'instructor' => ['instructors-control-courses', 'instructors-control-exams', 'buy-courses'],
        'student' => ['buy-courses'],
        'support' => ['support'],
        $role->name => abort(404)
      };
      $role->givePermissionTo($permissionsAsRole);
    }
  }
}
