<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tours;
use App\Models\Rentals;
use App\Models\Bookings;
use App\Models\Packages;
use Nette\Utils\DateTime;
use App\Models\Certificates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use phpseclib3\File\ASN1\Maps\Certificate;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $validator = Validator::make($request->all(), [
            'display_picture' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'user_type' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $users = User::where('email', $request['email'])->get();
        // dd($users);

        if ($users->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Email Already Exist']);
            die;
        }

        if ($request->file('display_picture')) {
            unset($input['display_picture']);
            $input += ['display_picture' => $this->updateprofile($request, 'display_picture', 'profileimage')];
        }

        // return $input;
        $input += ['is_active' => '1'];
        $input['password'] = bcrypt($input['password']);
        $input += ['otp' => rand(100000, 999999)];
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['user'] = $user;

        return $this->sendResponse($success, 'User Registered Successfully.');
    }

    public function registerdelete(Request $req, $id)
    {
        $email = $req->input('email');
        $password = $req->input('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'msg' => 'User not found'], 404);
        }

        if (password_verify($password, $user->password)) {
            $user->delete();

            return response()->json(['success' => true, 'msg' => 'User Deleted Successfully']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Email or Password is Incorrect'], 401);
        }
    }

    public function updateregister(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'display_picture' => 'required',
            // 'user_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            // 'gender' => 'required',
            // 'email' => 'required',
            // 'dob' => 'required',
            'phone' => 'required',
            // 'status' => 'required',
            // 'is_active' => 'required',
            // 'user_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        $input['password'] = bcrypt($input['password']);
        $input['confirm_password'] = bcrypt($input['confirm_password']);

        if ($req->file('display_picture')) {
            unset($input['display_picture']);
            $input += ['display_picture' => $this->updateprofile($req, 'display_picture', 'profileimage')];
        }

        unset($input['_token']);
        if (@$input['id']) {
            $userupdate = User::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Updated Successfully.', 'data' => User::where('id', $input['id'])->first()]);
        } else {
            $userupdate = User::create($input);
            return response()->json(['success' => true, 'msg' => 'User Created Successfully']);
        }
    }

    public function changepassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'current_password' => 'required'
            ]);
            $user = User::find(Auth::id());
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return $this->sendResponse($user, 'Password Changed Successfully!');
            } else {
                return $this->sendError('Current Password Mismatch!');
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function certificates(Request $req)
    {
        try {
            $input = $req->all();
            $validator = Validator::make($input, [
                'image' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()]);
            }

            unset($input['_token']);

            // $input += ['user_id' => Auth::user()->id];

            if ($req->hasFile('image')) {
                foreach ($input['image'] as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('public/profileimage', $imageName);
                    $data = [
                        'user_id' => $req->user_id,
                        'image' => env('APP_URL').'storage/profileimage/'.$imageName,
                    ];
                    Certificates::create($data);
                }
            }

            return response()->json(['success' => true, 'msg' => 'Certificate Created Successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function getcertificates()
    {
        $getcertificate = Certificates::get();
        return response()->json(['success' => true, 'data' => $getcertificate]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            // $success['email'] =  $user->email;
            $success['user'] = $user;
            return $this->sendResponse($success, 'User Login Successfully.');
        } else {
            return $this->sendResponse('Unauthorised.', ['error' => 'Email or Password Incorrect']);
            // return $this->sendError('Unauthorised.', ['error' => 'Incorrect ID Password']);
        }
    }

    public function userupdate(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'user_type' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }
        unset($input['_token']);
        if (@$input['id']) {
            $userupdate = User::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Updated Successfully.']);
        } else {
            $userupdate = User::create($input);
            return response()->json(['success' => true, 'msg' => 'User Created Successfully']);
        }
    }

    public function phoneotp(Request $req)
    {
        $otp = User::where('id', $req->user_id)->where('otp', $req->otp)->first();
        if (!empty($otp)) {
            return response()->json(['success' => true, 'msg' => 'Success']);
        }
        return response()->json(['success' => false, 'msg' => 'Please enter valid otp code']);
    }

    public function generateotp(Request $req)
    {
        $otp = rand(1000, 9999);
        $user = User::where('id', $req->user_id)->update(['otp' => $otp, 'phone' => $req->phone]);
        return response()->json(['success' => true, 'msg' => 'OTP Genrated', 'data' => $otp]);
    }

    public function vendordashboard()
    {
        $booking = Bookings::count();
        $currentDateTime = Carbon::now();
        $upcomingbookings = Bookings::where('datetime', '>', $currentDateTime)->count();
        $pastBooking =  Bookings::where('datetime', '<', $currentDateTime)->get();
        $pastTime = 0;
        if ($pastBooking->count() > 0) {
            foreach ($pastBooking as $key => $pb) {
                $pastTime += $pb->duration;
            }
        }

        $duration = $pastTime;
        $hours    = (int)($duration / 60);
        $minutes  = $duration - ($hours * 60);

        date_default_timezone_set('UTC');
        $date = new DateTime($hours . ":" . $minutes);
        //  echo $date->format('H:i:s');
        // dd($date->format('H:i:s'));
        return response()->json(['success' => true, 'msg' => 'Dashboard Data:', 'booking' => $booking, 'upcomingbookings' => $upcomingbookings, 'totaltime' => $date->format('H:i:s')]);
    }

    public function searchUser(Request $req)
    {
        $input = $req->all();
        $ser = $input['search'];
        $search = User::where('first_name', 'LIKE', "%$ser%")->orWhere('last_name', 'LIKE', "%$ser%")->get();
        // $search = DB::select("SELECT * FROM users WHERE first_name LIKE '" . $input['search'] . "%' OR last_name LIKE  '" . $input['search'] . "%' ");
        // dd($search);
        return $search;
    }

    public function search(Request $req)
    {
        $input = $req->all();
        $ser = $input['search'];

        $rentalResults = Rentals::with('Images')->where('title', 'LIKE', "%$ser%")->orWhere('desc', 'LIKE', "%$ser%")->get();
        $tourResults = Tours::with('Images')->where('title', 'LIKE', "%$ser%")->orWhere('desc', 'LIKE', "%$ser%")->get();

        // $searchResults['rentals'] = $rentalResults;
        // $searchResults['tours'] = $tourResults;

        $searchResults = [
            'search' => array_merge($rentalResults->toArray(), $tourResults->toArray()),
        ];

        return response()->json(['success' => true, 'data' => $searchResults]);
    }

    public function searchLoc(Request $req)
    {
        $input = $req->all();
        $ser = $input['search'];

        $rentalResults = Rentals::with('Images')->with('User')->where('locations', 'LIKE', "%$ser%")->get();
        $tourResults = Tours::with('Images')->where('locations', 'LIKE', "%$ser%")->get();

        // $searchLoc['rentals'] = $rentalResults;
        // $searchLoc['tours'] = $tourResults;

        $searchLoc = [
            'searchLoc' => array_merge($rentalResults->toArray(), $tourResults->toArray()),
        ];

        return $searchLoc;
    }

    public function searchTour(Request $req)
    {
        $input = $req->all();
        $ser = $input['search'];

        $searchTour = Tours::with('Images')->where('title', 'LIKE', "%$ser%")->orWhere('desc', 'LIKE', "%$ser%")->get();

        return response()->json(['success' => true, 'data' => $searchTour]);
    }

    public function popular()
    {
        $popular = Rentals::with('Images')->get();
        return response()->json(['success' => true, 'data' => $popular]);
    }
}
