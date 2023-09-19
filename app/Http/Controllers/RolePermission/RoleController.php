<?php

namespace App\Http\Controllers\RolePermission;

use App\Models\Role;
use App\Helper\Helper;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class RoleController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        if (Helper::permission('Roles.view')) {
            $roles = Role::withCount('countUser')->with('countUser.user')->with('role_permission.rolepermission')->get();
            return view('roles.role')->with('roles', $roles);
        } else {
            return view('error');
        }
        // return $this->sendResponse($roles, 'Role retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function getRolePermissions(Request $request)
    {
        // return Role::with('permission')->where('id',$request->role_id)->first();
        $data['role'] = Role::where('id', '=', $request->role_id)->first();
        $data['role']['permissions'] = Permission::join('role_permissions', 'permissions.id', 'role_permissions.permission_id')
            ->where('role_permissions.role_id', $request->role_id)->get();
        return $data;
    }
    public function store(Request $request)

    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'role_name' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if (Helper::permission('Roles.create')) {
            $role = Role::create($input);
            return $this->sendResponse(new RoleResource($role), 'Role created successfully.');
        }
        return response()->json(['success' => false, 'msg' => 'Access Denied']);
    }

    public function NoofUser($id)
    {
        $total = [];
        $roleArray = [];
        if ($id ==  'all') {
            $roles = Role::withCount('countUser')->get()->toArray();

            return $this->sendResponse($roles, 'Total No User');
        } else {
            $roles = Role::withCount('countUser')->with('countUser.user')->where('id', $id)->first();

            return $this->sendResponse($roles, 'Total No User');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)

    {
        $role = Role::find($id);
        if (is_null($role)) {
            return $this->sendError('Role not found.');
        }

        return $this->sendResponse(new RoleResource($role), 'Role retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Role $role)

    {
        if (Helper::permission('Roles.upadte')) {
            $input = $request->all();
            $validator = Validator::make($input, [
                'role_name' => 'required',

            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $role->role_name = $input['role_name'];
            $role->save();
            return $this->sendResponse(new RoleResource($role), 'Product updated successfully.');
        }
        return response()->json(['success' => false, 'msg' => 'Access Denied']);
    }



    /**
     * Remove the specified resource from storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Role $role)

    {
        $role->delete();
        return $this->sendResponse([], 'Role deleted successfully.');
    }
}
