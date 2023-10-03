<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingsController extends Controller
{
    public function bookings(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'comments' => 'required',
            'reviews' => 'required',
            'status' => 'required',
            'booking_type' => 'required',
            // 'datetime' => 'required',
            'duration' => 'required',
            'insurance_amount' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        $input += ['user_id' => Auth::user()->id];
        $input += ['datetime' => date('Y-m-d')];

        if (@$input['id']) {
            $bookings = Bookings::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Bookings Updated Successfully.']);
        } else {
            $bookings = Bookings::create($input);
            return response()->json(['success' => true, 'msg' => 'Bookings Created Successfully']);
        }
    }

    public function getbookings(Request $req)
    {
        $getbookings = Bookings::with('User')->get();
        return response()->json(['success' => true, 'data' => $getbookings]);
    }

    public function upcomingbookings()
    {
        $upcomingbookings = Bookings::where('datetime', '>', date('m/d/Y'))->where('status', 'upcoming')->get();
        return response()->json(['success' => true, 'data' => $upcomingbookings]);
    }

    public function pastbookings()
    {
        $pastbookings = Bookings::where('datetime', '<', date('m/d/Y'))->where('status', 'past')->get();
        return response()->json(['success' => true, 'data' => $pastbookings]);
    }
}
