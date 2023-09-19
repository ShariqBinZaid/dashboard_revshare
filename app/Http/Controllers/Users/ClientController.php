<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Helper\Helper;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Users\UserClientResource;

class ClientController extends Controller
{
    public function index()
    {
        return view('clients.client');
    }
    public function list(Request $req)
    {
        $req = $req->input();
        $users = User::where('user_type', '=', 'client')->get();
        return new UserClientResource($users);
    }

    public function store(Request $req)
    {
        $input = $req->all();
        unset($input['_token']);
        $validator = Validator::make($input, [
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required|unique:users,email,' . $input['id'],
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        if (@$input['password']) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }
        if ($req->file('display_picture')) {
            unset($input['display_picture']);
            $input += ['display_picture' => $this->updateprofile($req, 'display_picture')];
        }

        if (@$input['id']) {
            if (@$input['c_password']) {
                $user = User::find($input['id']);
                if (!Hash::check($input['c_password'], $user->password)) {
                    return response()->json(['success' => false, 'msg' => 'Incorrent Password']);
                }
            }
            unset($input['c_password']);
            // if (Helper::permission('Clients.update')) {
            $user = User::where("id", $input['id'])->update($input);
            if (!empty($input['role_id'])) {
                UserRole::where('user_id', $input['id'])->delete();
                foreach ($input['role_id'] as $role) {
                    $data = ['user_id' => $input['id'], 'role_id' => $role];
                    $userrole = UserRole::create($data);
                }
            }
            return response()->json(['success' => true, 'msg' => 'User Updated']);
            // }
            return response()->json(['success' => false, 'msg' => 'Access Denied']);
        } else {
            // if (Helper::permission('Clients.create')) {
            $input += ['user_type' => 'client'];
            $user = User::create($input);
            if (!empty($input['role_id'])) {
                foreach ($input['role_id'] as $role) {
                    $data = ['user_id' => $user->id, 'role_id' => $role];
                    $userrole = UserRole::create($data);
                }
            }
            return response()->json(['success' => true, 'msg' => 'User Created']);
            // }
            return response()->json(['success' => false, 'msg' => 'Access Denied']);
        }
    }

    public function show($id)
    {
        // $this->authorize('view', Auth::user());
        $User = User::with('role')->where('id', $id)->first();
        $User->display_picture = asset('storage/' . $User->display_picture);
        if (is_null($User)) {
            return response()->json(['success' => true, 'data' => 'Not Found']);
        }
        return response()->json(['success' => true, 'data' => $User]);
    }

    public function update(Request $request, $id)
    {

        $user = User::where("id", $id)->update(['is_active' => $request->input('is_active')]);
        return $this->sendResponse($user, 'User Update successfully.');
    }

    public function destroy($id)
    {
        // $this->authorize('delete', Auth::user());
        User::where('id', $id)->delete();
        echo json_encode(['success' => true, 'msg' => 'User deleted']);
    }
}
