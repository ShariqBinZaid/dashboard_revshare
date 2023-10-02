<?php

namespace App\Http\Controllers;

use App\Models\RentalAddons;
use App\Models\RentalImages;
use App\Models\RentalReviews;
use App\Models\Rentals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RentalsController extends Controller
{

    public function rentals(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'rental_addons_id' => 'required',
            'title' => 'required',
            'price' => 'required',
            'price_type' => 'required',
            'location' => 'required',
            'desc' => 'required',
            'comments' => 'required',
            'datetime' => 'required',
            'capacity' => 'required',
            'skills' => 'required',
            'cancel_days' => 'required',
            'cancel_percent' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        $input += ['user_id' => Auth::user()->id];

        if (@$input['id']) {
            $tours = Rentals::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Rentals Updated Successfully.']);
        } else {
            $tours = Rentals::create($input);
            return response()->json(['success' => true, 'msg' => 'Rentals Created Successfully']);
        }
    }

    public function getrentals()
    {
        $getrentals = Rentals::with('User', 'RentalAddons')->get();
        return response()->json(['success' => true, 'data' => $getrentals]);
    }

    public function rentaladdons(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        if (@$input['id']) {
            $rentaladdons = RentalAddons::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Rental Addons Updated Successfully.']);
        } else {
            $rentaladdons = RentalAddons::create($input);
            return response()->json(['success' => true, 'msg' => 'Rental Addons Created Successfully']);
        }
    }

    public function rentalreviews(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'rental_id' => 'required',
            'comments' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        $input += ['user_id' => Auth::user()->id];

        if (@$input['id']) {
            $rentalreviews = RentalReviews::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Rental Reviews Updated Successfully.']);
        } else {
            $rentalreviews = RentalReviews::create($input);
            return response()->json(['success' => true, 'msg' => 'Rental Reviews Created Successfully']);
        }
    }

    public function getrentalreviews()
    {
        $getrentalreviews = RentalReviews::with('User', 'Rental')->get();
        return response()->json(['success' => true, 'data' => $getrentalreviews]);
    }

    public function rentalimages(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'rental_id' => 'required',
            'image' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        if ($req->file('image')) {
            unset($input['image']);
            $input += ['image' => $this->updateprofile($req, 'image', 'profileimage')];
        }

        unset($input['_token']);

        if (@$input['id']) {
            $rentalreviews = RentalImages::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Rental Images Updated Successfully.']);
        } else {
            $rentalreviews = RentalImages::create($input);
            return response()->json(['success' => true, 'msg' => 'Rental Images Created Successfully']);
        }
    }

    public function getrentalimages()
    {
        $getrentalimages = RentalImages::with('Rental')->get();
        return response()->json(['success' => true, 'data' => $getrentalimages]);
    }
}
