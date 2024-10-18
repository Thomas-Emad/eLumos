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
      ['name' => 'owner'], ['name' => 'instructor'], ['name' => 'student']
    ];

    foreach ($roles as $role) {
      $role = Role::create($role);

      $permissionsAsRole = match ($role->name) {
        'owner' => ['users', 'roles', 'control-courses', 'buy-courses'],
        'instructor' => ['instructors-control-courses', 'instructors-control-exams', 'buy-courses'],
        'student' => ['buy-courses'],
        $role->name => abort(404)
      };
      $role->givePermissionTo($permissionsAsRole);
    }
  }
}
