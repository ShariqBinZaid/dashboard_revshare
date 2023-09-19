<?php

namespace App\Http\Controllers\RolePermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AttachController extends Controller
{
    //
    function permission_to_role(Request $request){
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if(DB::table('role_permissions')->where('role_id','=',$request->role_id)->where('permission_id','=',$request->permission_id)->exists()){
            return "Permission Already Attached To Role";
        }
        else{
            DB::table('role_permissions')->insert(['role_id' => $request->role_id,'permission_id' => $request->permission_id]);
            return "Done";
        }
    }

    function role_to_user(Request $request){

        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        if(DB::table('user_roles')->where('role_id','=',$request->role_id)->where('user_id','=',$request->user_id)->exists()){
            return "Role Already Attached To User";
        }
        else{
            DB::table('user_roles')->insert(['role_id' => $request->role_id,'user_id' => $request->user_id]);
            return "Done";
        }
    }

    public function storePermission(Request $req){
        $req = $req->all();
        $role = Role::where('role_name',$req['role_name'])->first();
        $role_id = '';
        $create_role = [];
       
        if(!empty($role)){
            $role_id = $role->id;
            $deleteRolePermission = RolePermission::where('role_id',$role->id)->delete();            
        }else{
            $create_role = Role::insertGetId(['role_name'=>$req['role_name']]); 
        }
        if(!empty($create_role)){
            $role_id = $create_role;
        }       
        if(!empty($req['permission_id'])){
            foreach ($req['permission_id'] as $k => $perm) {
                $data = ['role_id'=>$role_id,'permission_id'=>$perm];
                $permission = RolePermission::create($data);                    
            }
        }
        return response()->json(['success'=>true,'msg'=>'Permission Created']);        
    }
    



}
