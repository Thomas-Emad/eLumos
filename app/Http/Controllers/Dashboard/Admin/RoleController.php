<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Resources\ShowRoleInfoRescource;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return [
      'permission:roles',
    ];
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $roles = Role::with('permissions')->paginate(10);
    $permissions = Permission::all();
    return view('pages.dashboard.admin.roles', compact('roles', 'permissions'));
  }

  /**
   * Show Role
   */
  public function showRole(Request $request)
  {
    try {
      $role = Role::where('id', $request->input('id'))->firstOrFail();
      return response()->json(new ShowRoleInfoRescource($role), 200);
    } catch (\Exception $e) {
      return response()->json([
        'error' => $e->getMessage()
      ], 500);
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Validation request
    $validator = Validator::make($request->all(), [
      'name' => 'required|min:3|max:20',
      'permissions' => 'required',
    ]);
    if ($validator->fails()) {
      return redirect()->back()
        ->withInput()->with('notification', [
          'type' => 'fail',
          'message' => "Error in verifying data (" . $validator->errors()->count() . "): " . $validator->errors()->first()
        ]);
    }

    $role = Role::create(['name' => $request->input('name')]);
    $permissionIds = array_map('intval', $request->permissions);
    $role->syncPermissions($permissionIds);
    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => "Role Created Successfully"
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    // Validation request
    $validator = Validator::make($request->all(), [
      'name' => 'required|min:3|max:20|unique:roles,id,' . $request->id,
      'permissions' => 'required',
    ]);
    if ($validator->fails()) {
      return redirect()->back()
        ->withInput()->with('notification', [
          'type' => 'fail',
          'message' => "Error in verifying data (" . $validator->errors()->count() . "): " . $validator->errors()->first()
        ]);
    }

    $role = Role::where('id', $request->id)->firstOrFail();
    $role->name = $request->input('name');
    $role->save();

    $permissionIds = array_map('intval', $request->permissions);
    $role->syncPermissions($permissionIds);

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => "Role Updated Successfully"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    Role::destroy($request->input('id'));

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => "Deleted Role Has Been Done Successfully."
    ]);
  }

  /**
   * Retrieve users based on search query.
   *
   * @param Request $request The HTTP request object.
   * @return \Illuminate\Http\JsonResponse The JSON response containing the user data.
   */
  public function users(Request $request)
  {
    $users = User::where('name', "LIKE", "%" . $request->input('search') . "%")
      ->where(function ($q) use ($request) {
        if (!empty($request->input('role'))) {
          $q->role($request->input('role'));
        }
      })->get(['id', 'name', 'email']);
    return response()->json([
      'data' => UserResource::collection($users)
    ], 200);
  }

  /**
   * Change the role of a user.
   *
   * @param Request $request The HTTP request object containing the user ID and the new role ID.
   * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user with the given ID is not found.
   * @return \Illuminate\Http\RedirectResponse A redirect response with a success message.
   */
  public function changeRoleUser(Request $request)
  {
    $user = User::where('id', $request->input('id'))->firstOrFail();
    $user->syncRoles($request->input('role'));

    return redirect()->back()->with('notification', [
      'type' => 'success',
      'message' => "Changed Role User Has Been Done Successfully."
    ]);
  }
}
