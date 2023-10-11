<?php

namespace App\Http\Controllers;

use App\Models\BookingGroups;
use App\Models\Tours;
use App\Models\Bookings;
use App\Models\Categories;
use App\Models\Disputes;
use App\Models\ToursImages;
use Illuminate\Http\Request;
use App\Models\ToursBookings;
use App\Models\RentalBookings;
use App\Models\TourReviews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ToursController extends Controller
{

    public function tours(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'price' => 'required',
            'price_type' => 'required',
            'desc' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'whats_include' => 'required',
            'age' => 'required',
            'capacity' => 'required',
            'reviews' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        // if ($req->file('image')) {
        //     unset($input['image']);
        //     $input += ['image' => $this->updateprofile($req, 'image', 'profileimage')];
        // }

        unset($input['_token']);

        $input += ['user_id' => Auth::user()->id];

        if (@$input['id']) {
            $tours = Tours::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Tours Updated Successfully.']);
        } else {
            $tours = Tours::create($input);
            return response()->json(['success' => true, 'msg' => 'Tours Created Successfully', 'data' => $tours]);
        }
    }

    public function gettours()
    {
        $gettours = Tours::with('User')->get();
        return response()->json(['success' => true, 'data' => $gettours]);
    }

    public function getusertours($user_id)
    {
        $getusertours = Tours::with('User', 'Images')->where('user_id', $user_id)->get();
        $allImages = [];
        foreach ($getusertours as $getusertour) {
            $images = $getusertour->images;
            $allImages = array_merge($allImages, $images->toArray());
        }
        return response()->json(['success' => true, 'data' => $getusertours]);
    }

    public function getonetours($id)
    {
        $getonetours = Tours::with('User')->where('id', $id)->get();
        return response()->json(['success' => true, 'data' => $getonetours]);
    }

    // public function toursimages(Request $req)
    // {
    //     $input = $req->all();
    //     $validator = Validator::make($input, [
    //         'tour_id' => 'required',
    //         'image' => 'required',
    //     ]);

    //     // dd($input);
    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'error' => $validator->errors()]);
    //     }

    //     if ($req->file('image')) {
    //         unset($input['image']);
    //         $input += ['image' => $this->updateprofile($req, 'image', 'profileimage')];
    //     }

    //     unset($input['_token']);

    //     if (@$input['id']) {
    //         $toursimages = ToursImages::where("id", $input['id'])->update($input);
    //         return response()->json(['success' => true, 'msg' => 'Tours Images Updated Successfully.']);
    //     } else {
    //         $toursimages = ToursImages::create($input);
    //         return response()->json(['success' => true, 'msg' => 'Tours Images Created Successfully']);
    //     }
    // }

    public function toursimages(Request $req)
    {
        $input = $req->all();

        $validator = Validator::make($input, [
            'image' => 'required|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        if ($req->hasFile('image')) {
            $uploadedImages = [];

            foreach ($input['image'] as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/profileimage', $imageName);

                $uploadedImages[] = $imageName;
            }

            $input['image'] = $uploadedImages;
        }

        if (@$input['id']) {
            $tourimage = ToursImages::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Rental Images Updated Successfully.']);
        } else {
            $rentalimages = [];
            foreach ($input['image'] as $rentalimage) {
                $rentalimages[] = [
                    'tour_id' => $input['tour_id'],
                    'image' => $rentalimage,
                ];
            }

            $tourimage = ToursImages::insert($rentalimages);
            return response()->json(['success' => true, 'msg' => 'Rentals Images Created Successfully', 'data' => $tourimage]);
        }
    }

    public function gettoursimages()
    {
        $gettoursimages = ToursImages::with('Tour')->get();
        return response()->json(['success' => true, 'data' => $gettoursimages]);
    }

    public function getusertoursimages($tour_id)
    {
        $getusertoursimages = ToursImages::with('Tour')->where('tour_id', $tour_id)->get();
        return response()->json(['success' => true, 'data' => $getusertoursimages]);
    }

    public function toursreviews(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'tour_id' => 'required',
            'comment' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        $input += ['user_id' => Auth::user()->id];

        if (@$input['id']) {
            $toursreviews = TourReviews::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Tours Reviews Updated Successfully.']);
        } else {
            $toursreviews = TourReviews::create($input);
            return response()->json(['success' => true, 'msg' => 'Tours Reviews Created Successfully']);
        }
    }

    public function gettoursreviews()
    {
        $gettoursreviews = TourReviews::with('User', 'Tour')->get();
        return response()->json(['success' => true, 'data' => $gettoursreviews]);
    }

    public function getusertoursreviews($user_id, $tour_id)
    {
        $gettoursreviews = TourReviews::with('User', 'Tour')->where('user_id', $user_id)->where('tour_id', $tour_id)->get();
        return response()->json(['success' => true, 'data' => $gettoursreviews]);
    }

    public function toursbooking(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'tour_id' => 'required',
            'booking_id' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        if (@$input['id']) {
            $toursbooking = ToursBookings::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Tours Booking Updated Successfully.']);
        } else {
            $toursbooking = ToursBookings::create($input);
            return response()->json(['success' => true, 'msg' => 'Tours Booking Created Successfully']);
        }
    }

    public function gettoursbooking()
    {
        $gettoursbooking = ToursBookings::with('Booking', 'Tour')->get();
        return response()->json(['success' => true, 'data' => $gettoursbooking]);
    }

    public function getusertoursbooking($booking_id, $tour_id)
    {
        $getusertoursbooking = ToursBookings::with('Booking', 'Tour')->where('booking_id', $booking_id)->where('tour_id', $tour_id)->get();
        return response()->json(['success' => true, 'data' => $getusertoursbooking]);
    }


    // public function bookings(Request $req)
    // {
    //     $input = $req->all();
    //     $validator = Validator::make($input, [
    //         'comments' => 'required',
    //         'reviews' => 'required',
    //         'status' => 'required',
    //         'booking_type' => 'required',
    //         // 'datetime' => 'required',
    //         'duration' => 'required',
    //         'insurance_amount' => 'required',
    //     ]);

    //     // dd($input);
    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'error' => $validator->errors()]);
    //     }

    //     unset($input['_token']);

    //     $input += ['user_id' => Auth::user()->id];
    //     $input += ['datetime' => date('Y-m-d')];

    //     if (@$input['id']) {
    //         $bookings = Bookings::where("id", $input['id'])->update($input);
    //         return response()->json(['success' => true, 'msg' => 'Bookings Updated Successfully.']);
    //     } else {
    //         $bookings = Bookings::create($input);
    //         return response()->json(['success' => true, 'msg' => 'Bookings Created Successfully']);
    //     }
    // }

    // public function getbookings(Request $req)
    // {
    //     $getbookings = Bookings::with('User')->get();
    //     return response()->json(['success' => true, 'data' => $getbookings]);
    // }

    public function rentalbookings(Request $req)
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
            $rentalbookings = RentalBookings::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Rentals Bookings Updated Successfully.']);
        } else {
            $rentalbookings = RentalBookings::create($input);
            return response()->json(['success' => true, 'msg' => 'Rentals Bookings Created Successfully']);
        }
    }

    public function getrentalbookings()
    {
        $rentalbookings = RentalBookings::with('Booking', 'Rental')->get();
        return response()->json(['success' => true, 'data' => $rentalbookings]);
    }

    public function getuserrentalbookings($booking_id, $rental_id)
    {
        $rentalbookings = RentalBookings::with('Booking', 'Rental')->where('booking_id', $booking_id)->where('rental_id', $rental_id)->get();
        return response()->json(['success' => true, 'data' => $rentalbookings]);
    }

    public function dispute(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'booking_id' => 'required',
            'comments' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        $input += ['user_id' => Auth::user()->id];

        if (@$input['id']) {
            $dispute = Disputes::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Disputes Updated Successfully.']);
        } else {
            $dispute = Disputes::create($input);
            return response()->json(['success' => true, 'msg' => 'Disputes Created Successfully']);
        }
    }

    public function bookingsgroups(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'booking_id' => 'required',
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
            $bookingsgroups = BookingGroups::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Booking Groups Updated Successfully.']);
        } else {
            $bookingsgroups = BookingGroups::create($input);
            return response()->json(['success' => true, 'msg' => 'Booking Groups Created Successfully']);
        }
    }

    // public function getbookingsgroups()
    // {
    //     $getbookingsgroups = BookingGroups::with('Booking')->get();
    //     return response()->json(['success' => true, 'data' => $getbookingsgroups]);
    // }
}
