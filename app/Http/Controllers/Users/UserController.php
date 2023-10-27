<?php

namespace App\Http\Controllers\Users;

use App\Models\Role;
use App\Models\User;
use App\Helper\Helper;
use App\Models\UserRole;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Users\UserAdminResource;
use App\Models\UserInType;
use App\Models\UserType;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class UserController extends Controller
{

    public function index()
    {
        $data['roles'] = Role::all();
        $data['user_type'] = UserType::all();
        return view('Users.user')->with($data);
    }

    public function list(Request $req)
    {
        $req = $req->input();
        // $users = UserInType::with('user')->whereIn('user_type', [1])->groupBy('user_id')->get();
        $users = User::where('user_type', 'admin')->get();

        return new UserAdminResource($users);
    }


    public function store(Request $req)
    {

        $input = $req->all();
        // dd($req->file());
        $roles = @$input['roles'];

        $validator = Validator::make($input, [
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required|unique:users,email,' . $input['id'],
        ]);

        unset($input['_token']);
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
            $input += ['display_picture' => $this->updateprofile($req, 'display_picture', 'profileimage')];
        }

        if (@$input['id']) {
            if (@$input['c_password']) {
                $user = User::find($input['id']);
                if (!Hash::check($input['c_password'], $user->password)) {
                    return response()->json(['success' => false, 'msg' => 'Incorrent Password']);
                }
            }
            unset($input['c_password']);
            // if (Helper::permission('Users.update')) {
                $user = User::where("id", $input['id'])->update($input);

                return response()->json(['success' => true, 'msg' => 'User Updated']);
            // }
            return response()->json(['success' => false, 'msg' => 'Access Denied']);
        } else {
            // if (Helper::permission('Users.create')) {
                $user = User::create($input);

                return response()->json(['success' => true, 'msg' => 'User Created']);
            // }
            return response()->json(['success' => false, 'msg' => 'Access Denied']);
        }
    }

    public function UserRoleStore($roles, $user_id, $action = 'create')
    {
        if ($action == 'update') {
            UserRole::where('user_id', $user_id)->delete();
        }
        if (!empty($roles)) {
            foreach ($roles as $role) {
                $data = ['user_id' => $user_id, 'role_id' => $role];
                $userrole = UserRole::create($data);
            }
        }
        return true;
    }


    public function UserTypeStore($userTypes, $user_id, $action = 'create')
    {
        if ($action == 'update') {
            UserInType::where('user_id', $user_id)->delete();
        }
        if (!empty($userTypes)) {
            foreach ($userTypes as $userType) {
                $data = ['user_id' => $user_id, 'user_type' => $userType];
                UserInType::create($data);
            }
        }
        return true;
    }

    public function show($id)
    {
        $User = User::with('role')->where('id', $id)->first();
        $roles = [];
        if ($User->role->count() > 0) {
            foreach ($User->role as $key => $role) {
                $roles[] = $role->id;
            }
        }
        $User->roles = $roles;
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
        User::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'User deleted']);
    }
}
