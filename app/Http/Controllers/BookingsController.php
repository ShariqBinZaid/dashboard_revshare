<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bookings;
use Illuminate\Http\Request;
use App\Models\BookingGroups;
use App\Models\BookingRentals;
use App\Models\BookingTours;
use App\Models\RentalBookings;
use App\Models\Tours;
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
        $tourRental = $input['tour_rental_id'];
        unset($input['_token'], $input['tour_rental_id']);

        $input += ['user_id' => Auth::user()->id];
        $input += ['datetime' => date('Y-m-d')];

        if (@$input['id']) {
            $bookings = Bookings::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Bookings Updated Successfully.']);
        } else {
            $bookings = Bookings::create($input);
            if ($input['booking_type'] == "tours") {
                ToursBookings::create(['booking_id' => $bookings->id, 'tour_id' => $tourRental]);
            }
            if ($input['booking_type'] == "rentals") {
                RentalBookings::create(['booking_id' => $bookings->id, 'rental_id' => $tourRental]);
            }
            return response()->json(['success' => true, 'msg' => 'Bookings Created Successfully', 'data' => $bookings]);
        }
    }

    public function getuserbookings($user_id)
    {

        $UpCommingtours = Tours::with('User', 'getbooking.Tourbooking')->where('user_id', $user_id)->get();
        $upComming = [];
        if ($UpCommingtours->count() > 0) {
            foreach ($UpCommingtours as $key => $value) {
                foreach ($value  as $booking) {
                    dd($value);
                    if ($value->datetime > Carbon::today()) {
                        $upComming[] = $value;
                    }
                }
            }
        }
        // if($tours->count() > 0){
        //     foreach ($tours as $key => $tours) {
        //         # code...
        //     }
        // }
        $getbookings = Bookings::with('User')->where('user_id', $user_id)->get();
        return response()->json(['success' => true, 'data' => $upComming]);
    }

    public function getbookings(Request $req)
    {
        $getbookings = Bookings::with('User')->get();
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

    public function getuserbookingtours($user_id)
    {
        $getbookingtours = Bookings::with('Tour')->where('user_id', $user_id)->get();
        return response()->json(['success' => true, 'data' => $getbookingtours]);
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

    // public function getuserbookingGroups($booking_id)
    // {
    //     $getbookingGroups = BookingGroups::where('booking_id', $booking_id)->get();
    //     return response()->json(['success' => true, 'data' => $getbookingGroups]);
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
