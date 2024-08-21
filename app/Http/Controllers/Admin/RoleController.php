<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Resources\ShowRoleInfoRescource;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Resources\UserResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        $permissions = Permission::all();
        return view('dashboard.admin.roles', compact('roles', 'permissions'));
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            return back()->with('message.error', 'Validation Error => ' . $validator->errors()->first());
        }

        $role = Role::create(['name' => $request->input('name')]);
        $permissionIds = array_map('intval', $request->permissions);
        $role->syncPermissions($permissionIds);
        return back()->with('message.success', 'Created Role Has Been Done Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
            return back()->with('message.error', 'Validation Error => ' . $validator->errors()->first());
        }

        $role = Role::where('id', $request->id)->firstOrFail();
        $role->name = $request->input('name');
        $role->save();

        $permissionIds = array_map('intval', $request->permissions);
        $role->syncPermissions($permissionIds);

        return back()->with('message.success', 'Updated Role Has Been Done Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Role::destroy($request->input('id'));

        return back()->with('message.success', 'Deleted Role Has Been Done Successfully.');
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
        return back()->with('message.success', 'Changed Role User Has Been Done Successfully.');
    }
}
