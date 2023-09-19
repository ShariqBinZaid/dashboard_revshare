<?php

namespace App\Http\Controllers\RolePermission;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Modules;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Users\UserAdminResource;
use App\Models\UserRole;

class RolePermissionController extends Controller
{
    //
    public function index($id)
    {
        $data['role'] =  $this->getpermissiontorole($id, true);
        $data['role_id'] = $id;
        $data['count'] = Role::withcount('user')->where('id', $id)->first();

        return view('roles.view')->with($data);
    }
    function getUserRoles(Request $request)
    {

        return User::with('role')->where('id', $request->user_id)->first();
    }

    public function list(Request $req)
    {
        $req = $req->input();

        $user = Role::with('user')->where('id', $req['role_id'])->get();

        return new RoleResource($user);
    }

    function getRolePermissions(Request $request)
    {
        // return Role::with('permission')->where('id',$request->role_id)->first();
        $data['role'] = Role::where('id', '=', $request->role_id)->first();
        $data['role']['permissions'] = Permission::join('role_permissions', 'permissions.id', 'role_permissions.permission_id')
            ->where('role_permissions.role_id', $request->role_id)->get();
        return $data;
    }

    public function getpermissiontorole($id, $index = false)
    {

        $roles = Role::with('role_permission')->where('id', $id)->first();
        $modules = Modules::with('permission')->get();

        $permissionSets = [];
        $moduleSets = [];
        if ($id) {
            if ($roles->count() > 0) {
                foreach ($roles->role_permission as $role) {
                    array_push($permissionSets, $role->permission_id);
                }
            }
        }

        if ($modules->count() > 0) {
            foreach ($modules as $module) {
                $permissions = [];
                if ($module->permission->count() > 0) {
                    foreach ($module->permission as $permission) {
                        $checkActivePermission = false;
                        if (in_array($permission->id, $permissionSets)) {
                            $checkActivePermission = true;
                        }
                        $permissions[] = [
                            'id' => $permission->id,
                            'name' => $permission->permission_name,
                            'is_active' => $checkActivePermission
                        ];
                    }
                }
                $moduleSets[] = [
                    'id' => $module->id,
                    'name' => $module->name,
                    'permissions' => $permissions
                ];
            }
        }
        if ($id) {
            $finalOutput = [
                'role' => [
                    'name' => $roles->role_name,
                    'modules' => $moduleSets
                ]
            ];
        } else {
            $finalOutput = [
                'modules' => $moduleSets

            ];
        }
        if ($index == false) {
            return response()->json($finalOutput);
        } else {
            return $finalOutput;
        }
    }

    public function remove($id)
    {
        UserRole::where('user_id', $id)->delete();
        return response()->json(['success' => true, 'msg' => 'User Removed']);
    }
    public function destory($id)
    {
        UserRole::where('user_id', $id)->delete();
        Role::where('id', $id)->delete();
        return response()->json(['success' => true, 'msg' => 'User Removed']);
    }

    function getSelfRoles(Request $request)
    {

        return User::with('role')->where('id', Auth::user()->id)->first();
    }
}
//create
//view
//update
//delete
//read_all