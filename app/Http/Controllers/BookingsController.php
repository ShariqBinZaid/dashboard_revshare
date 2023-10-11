<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bookings;
use Illuminate\Http\Request;
use App\Models\BookingGroups;
use App\Models\BookingRentals;
use App\Models\BookingTours;
use App\Models\RentalBookings;
use App\Models\ToursBookings;
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
            // 'reviews' => 'required',
            // 'status' => 'required',
            'booking_type' => 'required',
            // 'datetime' => 'required',
            // 'duration' => 'required',
            // 'insurance_amount' => 'required',
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
            return response()->json(['success' => true, 'msg' => 'Bookings Created Successfully', 'data' => $bookings]);
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

    public function bookingtours(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'booking_id' => 'required',
            'tour_id' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        if (@$input['id']) {
            $bookingtours = ToursBookings::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Booking Tours Updated Successfully.']);
        } else {
            $bookingtours = ToursBookings::create($input);
            return response()->json(['success' => true, 'msg' => 'Booking Tours Created Successfully']);
        }
    }

    public function getbookingtours()
    {
        $getbookingtours = ToursBookings::with('Booking', 'Tour')->get();
        return response()->json(['success' => true, 'data' => $getbookingtours]);
    }

    // public function getuserbookingtours($booking_id, $tour_id)
    // {
    //     $getbookingtours = ToursBookings::with('Booking', 'Tour')->where('booking_id', $booking_id)->where('tour_id', $tour_id)->get();
    //     return response()->json(['success' => true, 'data' => $getbookingtours]);
    // }

    public function getuserbookingtours()
    {
        $getbookingtours = Bookings::with('Tour')->get();
        return response()->json(['success' => true, 'data' => $getbookingtours]);
    }

    public function bookingrentals(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'booking_id' => 'required',
            'rental_id' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        if (@$input['id']) {
            $bookingtours = RentalBookings::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Rental Bookings Updated Successfully.']);
        } else {
            $bookingtours = RentalBookings::create($input);
            return response()->json(['success' => true, 'msg' => 'Rental Bookings Created Successfully']);
        }
    }

    public function getbookingrentals()
    {
        $getbookingrentals = RentalBookings::with('Booking', 'Rental')->get();
        return response()->json(['success' => true, 'data' => $getbookingrentals]);
    }

    public function getuserbookingrentals($booking_id, $rental_id)
    {
        $getbookingrentals = RentalBookings::with('Booking', 'Rental')->where('booking_id', $booking_id)->where('rental_id', $rental_id)->get();
        return response()->json(['success' => true, 'data' => $getbookingrentals]);
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

    // public function upcomingbookings()
    // {
    //     $upcomingbookings = Bookings::where('datetime', '=>', date('Y/m/d'))->get();
    //     // dd($upcomingbookings);
    //     return response()->json(['success' => true, 'data' => $upcomingbookings]);
    // }

    // public function pastbookings()
    // {
    //     $pastbookings = Bookings::where('datetime', '<', date('Y/m/d'))->get();
    //     // dd($pastbookings);
    //     return response()->json(['success' => true, 'data' => $pastbookings]);
    // }

    public function pastbookings()
    {
        $currentDateTime = Carbon::now();
        $pastbookings = Bookings::with('User')->where('datetime', '<', $currentDateTime)->get();
        return response()->json(['success' => true, 'data' => $pastbookings]);
    }

    public function upcomingbookings()
    {
        $currentDateTime = Carbon::now();
        $upcomingbookings = Bookings::with('User')->where('datetime', '>', $currentDateTime)->get();
        return response()->json(['success' => true, 'data' => $upcomingbookings]);
    }
}
