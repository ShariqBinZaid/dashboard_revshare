<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;


class RegisterController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        // $name = explode(' ', $request->displayName);
        // if (sizeOf($name) > 1) {
        //     $first_name = $name[0];
        //     $last_name = $name[1];
        // } else {
        //     $first_name = $name[0];
        //     $last_name = '';
        // }
        if (DB::table('users')->where('email', '=', $request->email)->exists()) {
            $peta['status'] = 200;
            $peta['data']['error'] = array();
            $neta['type'] = 'email';
            $neta['message'] = 'The email address is already in use';
            array_push($peta['data']['error'], $neta);


            return response()->json($peta['data']);
        }
        $input = $request->all();
        $request->password = bcrypt($request->password);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'user_type' => $request->user_type,
            'display_picture' => $this->updateprofile($request, 'display_picture'),
            'cover_picture' => $this->updateprofile($request, 'cover_picture'),
            'is_active' => 1,
        ]);

        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->first_name . ' ' . $user->last_name;

        $data['user']['uuid'] = $user->id;
        $data['user']['from'] = "custom-db";
        $data['user']['role'] = "$request->user_type";
        $data['user']['data']['displayName'] = $user->first_name . ' ' . $user->last_name;
        $data['user']['data']['photoURL'] = "assets/images/avatars/brian-hughes.jpg";
        $data['user']['data']['email'] = $user->email;
        $data['user']['data']['settings']['layout'] = (object)[];
        $data['user']['data']['settings']['theme'] = (object)[];
        $data['user']['data']['shortcuts'] = [
            "apps.calendar",
            "apps.mailbox",
            "apps.contacts"
        ];
        $data['access_token'] = $user->createToken('MyApp')->accessToken;

        return response()->json($data);
        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $getUser  = User::where('email', $request->email)->where('user_type', '!=', 'user')->where('is_active', 1)->first();
        if (!empty($getUser)) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $success['name'] =  $user->name;
                $users =  User::with('role')->where('id', Auth::user()->id)->first();
                $success['users'] =  $users;
                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
    public function clientlogin(Request $request)
    {
        $getUser  = User::where('email', $request->email)->where('user_type', '=', 'user')->where('is_active', 1)->first();
        if (!empty($getUser)) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $success['name'] =  $user->name;
                $users =  User::with('role')->where('id', Auth::user()->id)->first();
                $success['users'] =  $users;
                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
            }
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
    public function updateprofile(Request $request, $file)
    {
        $p = $request->input();
        $path = '';
        if ($request->file($file)) {
            $request->validate([
                $file => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imagePath = $request->file($file);
            $imageName = $imagePath->getClientOriginalName();
            $path = $request->file($file)->storeAs('profileimage', time() . $imageName);
        }
        return $path;
    }

    public function clientregister(Request $req)
    {

        // $name = explode(' ', $req->displayName);
        // $first_name = $name[0];
        // $last_name = '';
        // $display_picture = '';
        // if (sizeOf($name) > 1) {
        //     $last_name = $name[1];
        // }
        if (DB::table('users')->where('email', '=', $req->email)->exists()) {
            $peta['status'] = 200;
            $peta['data']['error'] = array();
            $neta['type'] = 'email';
            $neta['message'] = 'The email address is already in use';
            array_push($peta['data']['error'], $neta);
            return response()->json($peta['data']);
        }
        $req->password = bcrypt($req->password);
        $user = User::create([
            'first_name' => $req->first_name,
            'last_name' => $req->last_name,
            'email' => $req->email,
            'password' => $req->password,
            'display_picture' => $this->updateprofile($req, 'display_picture'),
            'cover_picture' => $this->updateprofile($req, 'cover_picture'),
            'user_type' => 'user'
        ]);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $data['user'] = $user;
        $data['access_token'] = $user->createToken('MyApp')->accessToken;

        return response()->json(['success' => true, 'data' => $data]);
    }


    public function clientview()
    {
        $user = User::with('role')->where('user_type', 'user')->get();
        return response()->json($user);
    }
    public function usercurrent()
    {
        try {
            $users =  User::with('role')->where('id', Auth::user()->id)->first();
            return response()->json($users);
        } catch (\Throwable $th) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
