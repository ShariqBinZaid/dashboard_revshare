<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoginUserResource;
use App\Mail\VerifyOTP;
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
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required',
                'dob' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            $display_picture = null;
            if ($request->file('display_picture')) {
                $display_picture = $this->updateprofile($request, 'display_picture', 'profileimage');
            }
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'password' => Hash::make($request->password),
                'display_picture' => $display_picture,
                'otp' => rand('1000', '9999'),
                'is_active' => 0,
                'user_type' => $request->user_type
            ]);
            Mail::to($user->email)->send(new VerifyOTP($user));
            return $this->sendResponse(['id' => $user->id], 'User Registered Successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function verify(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|numeric',
                'otp' => 'required|numeric'
            ]);
            $user = User::where('id', $request->id)->where('otp', $request->otp)->first();
            if (!$user) {
                throw new \Exception('Invalid OTP!');
            }
            if ($user->is_active == 1) {
                throw new \Exception('OTP already used to verify account!');
            }
            $user->is_active = 1;
            $user->save();
            $token = $user->createToken('MyApp')->accessToken;
            Auth::login($user);
            return $this->sendResponse(new LoginUserResource(Auth::user()), 'User verified successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
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
        try {
            $req->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'phone' => 'required',
                'dob' => 'required'
            ]);
            $user = Auth::user();
            $user->first_name = $req->first_name;
            $user->last_name = $req->last_name;
            $user->gender = $req->gender;
            $user->phone = $req->phone;
            $user->dob = Carbon::parse($req->dob)->format('Y-m-d');
            if ($req->file('display_picture')) {
                $user->display_picture = $this->updateprofile($req, 'display_picture', 'profileimage');
            }
            $user->save();
            return $this->sendResponse(['success' => true, 'data' => $user], 'User Updated Successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
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
                        'image' => env('APP_URL') . 'storage/profileimage/' . $imageName,
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
        try {
            //Verify credentials
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                throw new \Exception('Invalid Credentials!');
            }
            //Check user type
            if (Auth::user()->user_type != 'user' || Auth::user()->user_type != 'vendor') {
                throw new \Exception('Invalid user type');
            }
            //Check if user is verified
            if (Auth::user()->is_active == 0) {
                throw new \Exception('Please verify your account');
            }
            return $this->sendResponse(new LoginUserResource(Auth::user()), 'User logged in successfully!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
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
    public function vendordashboard()
    {
        $booking = Bookings::count();
        $currentDateTime = Carbon::now();
        $upcomingbookings = Bookings::where('datetime', '>', $currentDateTime)->count();
        $pastBooking = Bookings::where('datetime', '<', $currentDateTime)->get();
        $pastTime = 0;
        if ($pastBooking->count() > 0) {
            foreach ($pastBooking as $key => $pb) {
                $pastTime += $pb->duration;
            }
        }

        $duration = $pastTime;
        $hours = (int)($duration / 60);
        $minutes = $duration - ($hours * 60);

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

    public function fcmid(Request $request)
    {
        try {
            $request->validate([
                'fcm_id' => 'required'
            ]);
            $user = Auth::user();
            $user->fcm_id = $request->fcm_id;
            $user->save();
            return $this->sendResponse([], 'FCM ID Updated!');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
