<?php

namespace App\Http\Controllers\RolePermission;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PermissionResource;
use App\Models\Modules;
use Illuminate\Support\Facades\Auth;


class PermissionController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $permissions = Permission::all();
        return $this->sendResponse(PermissionResource::collection($permissions), 'Permission retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)

    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'permission_name' => 'required',
            'module_id' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $module = Permission::where('permission_name',$input['permission_name'])->get()->toArray();
    
        if(!empty($module)){
            $permission = Permission::where('permission_name', $input['permission_name'])->delete();
            return $this->sendResponse($input, 'Permission Deleted successfully.');
        }else{
            $permission = Permission::create($input);
            return $this->sendResponse(new PermissionResource($permission), 'Permission created successfully.');
         
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
        $permission = Permission::find($id);
        if (is_null($permission)) {
            return $this->sendError('Permission not found.');
        }

        return $this->sendResponse(new PermissionResource($permission), 'Permission retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Permission $permission)

    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'permission_name' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $permission->permission_name = $input['permission_name'];
        $permission->save();
        return $this->sendResponse(new PermissionResource($permission), 'Product updated successfully.');

    }



    /**
     * Remove the specified resource from storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Permission $permission)

    {
        $permission->delete();
        return $this->sendResponse([], 'Permission deleted successfully.');
    }

}

