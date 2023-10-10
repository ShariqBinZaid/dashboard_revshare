<?php

namespace App\Http\Controllers;

use App\Models\BookingGroups;
use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\XmlConfiguration\Group;

class BookingsController extends Controller
{
    public function bookings(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'comments' => 'required',
            'reviews' => 'required',
            // 'status' => 'required',
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

    public function getuserbookings($user_id)
    {
        $getbookings = Bookings::with('User')->where('user_id', $user_id)->get();
        return response()->json(['success' => true, 'data' => $getbookings]);
    }

    public function bookingGroups(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'adults' => 'required',
            'seniors' => 'required',
            'childrens' => 'required',
            'infants' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        if (@$input['id']) {
            $bookings = BookingGroups::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Booking Groups Updated Successfully.']);
        } else {
            $bookings = BookingGroups::create($input);
            return response()->json(['success' => true, 'msg' => 'Booking Groups Created Successfully']);
        }
    }

    public function getbookingGroups()
    {
        $getbookingGroups = BookingGroups::with('Booking')->get();
        return response()->json(['success' => true, 'data' => $getbookingGroups]);
    }

    public function getuserbookingGroups($booking_id)
    {
        $getbookingGroups = BookingGroups::where('booking_id', $booking_id)->get();
        return response()->json(['success' => true, 'data' => $getbookingGroups]);
    }

    public function upcomingbookings()
    {
        $upcomingbookings = Bookings::where('datetime', '=>', date('Y/m/d'))->get();
        // dd($upcomingbookings);
        return response()->json(['success' => true, 'data' => $upcomingbookings]);
    }

    public function pastbookings()
    {
        $pastbookings = Bookings::where('datetime', '<', date('Y/m/d'))->get();
        dd($pastbookings);

        return response()->json(['success' => true, 'data' => $pastbookings]);
    }
}
