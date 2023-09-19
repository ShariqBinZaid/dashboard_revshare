<?php

namespace App\Http\Controllers\Modules;

use App\Helper\Helper;
use App\Models\Modules;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ModuleResource;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Validator;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Helper::permission('Modules.view')) {
            return view('modules.modules');
        } else {
            return view('error');
        }
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $modules = Modules::with('permission')->get();
        return new ModuleResource($modules);
    }

    public function store(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'name' => 'required',

        ]);
        unset($input['_token'],);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if (@$input['id']) {
            if (Helper::permission('Modules.update')) {
                $Modules  = Modules::where("id", $input['id'])->update(['name' => $input['name']]);
                Permission::where('module_id', $input['id'])->delete();
                $this->addperm($input['id'], $input);
                return response()->json(['success' => true, 'msg' => 'Module Update']);
            }
            return response()->json(['success' => false, 'msg' => 'Access Denied']);
        } else {
            if (Helper::permission('Modules.create')) {
                $Modules = Modules::create(['name' => $input['name']]);
                $this->addperm($Modules->id, $input);
                return response()->json(['success' => true, 'msg' => 'Module Created']);
            }
            return response()->json(['success' => false, 'msg' => 'Access Denied']);
        }
    }

    public function addperm($module_id, $input)
    {
        if (isset($input['view_all'])) {
            $perm = Permission::create(['permission_name' => str_replace([' '], [''], $input['name']) . '.view_all', 'module_id' => $module_id]);
        }
        if (isset($input['view'])) {
            $perm = Permission::create(['permission_name' => str_replace([' '], [''], $input['name']) . '.view', 'module_id' => $module_id]);
        }
        if (isset($input['create'])) {
            $perm = Permission::create(['permission_name' => str_replace([' '], [''], $input['name']) . '.create', 'module_id' => $module_id]);
        }
        if (isset($input['update'])) {
            $perm = Permission::create(['permission_name' => str_replace([' '], [''], $input['name']) . '.update', 'module_id' => $module_id]);
        }
        if (isset($input['delete'])) {
            $perm = Permission::create(['permission_name' => str_replace([' '], [''], $input['name']) . '.delete', 'module_id' => $module_id]);
        }
        return true;
    }
    public function show($id)
    {
        if ($id == "all") {
            $Modules = Modules::with('permission')->get();
            return $this->sendResponse($Modules, 'Module retrieved successfully.');
        } else {
            $Modules = Modules::with('permission')->where('id', $id)->first();

            if (is_null($Modules)) {
                return $this->sendError('Module not found.');
            }
            return response()->json(['success' => true, 'data' => $Modules]);
            // return $this->sendResponse($Modules, 'Module retrieved successfully.');
        }
    }
    public function destroy($id)
    {
        Modules::where('id', $id)->delete();
        return $this->sendResponse([], 'Module deleted successfully');
    }
}
