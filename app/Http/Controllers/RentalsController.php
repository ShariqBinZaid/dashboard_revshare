<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rentals;
use App\Models\RentalAddons;
use App\Models\RentalImages;
use Illuminate\Http\Request;
use App\Models\RentalReviews;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RentalsResource;
use Illuminate\Support\Facades\Validator;

class RentalsController extends Controller
{

    public function index()
    {
        $data['rentals'] = Rentals::get();
        $data['users'] = User::all();
        $data['rentaladdons'] = RentalAddons::all();
        return view('rentals.index')->with($data);
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $rentals = Rentals::get();
        return new RentalsResource($rentals);
    }

    public function show($id)
    {
        if ($id ==  "all") {
            $rentals = Rentals::all();
            return new RentalsResource($rentals);
        } else {
            $rentals = Rentals::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $rentals]);
        }
    }

    public function destroy(Request $req, $id)
    {
        Rentals::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Rentals Deleted']);
    }

    public function store(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'price' => 'required',
            'price_type' => 'required',
            'locations' => 'required',
            'desc' => 'required',
            // 'comments' => 'required',
            // 'datetime' => 'required',
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
            $rentals = Rentals::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Rentals Updated Successfully.']);
        } else {
            $rentals = Rentals::create($input);
            return response()->json(['success' => true, 'msg' => 'Rentals Created Successfully', 'data' => $rentals]);
        }
    }

    public function getrentals()
    {
        $getrentals = Rentals::with('User', 'RentalAddons', 'RentalImages')->get();
        return response()->json(['success' => true, 'data' => $getrentals]);
    }

    public function getuserrentals($user_id)
    {
        $getuserrentals = Rentals::with('User', 'RentalImages')->where('user_id', $user_id)->get();
        // $allImages = [];
        // foreach ($getuserrentals as $getuserrental) {
        //     $images = $getuserrental->images;
        //     $allImages = array_merge($allImages, $images->toArray());
        // }
        return response()->json(['success' => true, 'data' => $getuserrentals]);
    }

    public function getonerentals($id)
    {
        $getonerentals = Rentals::with('User', 'Images')->where('id', $id)->get();
        $allImages = [];
        foreach ($getonerentals as $getuserrental) {
            $images = $getuserrental->images;
            $allImages = array_merge($allImages, $images->toArray());
        }
        return response()->json(['success' => true, 'data' => $getonerentals]);
    }

    public function getcategoryrentals($category_id)
    {
        $getonerentals = Rentals::with('Categories', 'RentalImages', 'RentalAddons')->where('category_id', $category_id)->get();
        // $allImages = [];
        // foreach ($getonerentals as $getuserrental) {
        //     $images = $getuserrental->images;
        //     $allImages = array_merge($allImages, $images->toArray());
        // }
        return response()->json(['success' => true, 'data' => $getonerentals]);
    }

    // public function rentaladdons(Request $req)
    // {
    //     $input = $req->all();
    //     $validator = Validator::make($input, [
    //         'name' => 'required',
    //         'price' => 'required',
    //     ]);

    //     // dd($input);
    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'error' => $validator->errors()]);
    //     }

    //     unset($input['_token']);

    //     if (@$input['id']) {
    //         $rentaladdons = RentalAddons::where("id", $input['id'])->update($input);
    //         return response()->json(['success' => true, 'msg' => 'Rental Addons Updated Successfully.']);
    //     } else {
    //         $rentaladdons = RentalAddons::create($input);
    //         return response()->json(['success' => true, 'msg' => 'Rental Addons Created Successfully', 'data' => $rentaladdons]);
    //     }
    // }

    // public function getrentaladdons()
    // {
    //     $getrentaladdons = RentalAddons::get();
    //     return response()->json(['success' => true, 'data' => $getrentaladdons]);
    // }

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
            return response()->json(['success' => true, 'msg' => 'Rental Reviews Created Successfully', 'data' => $rentalreviews]);
        }
    }

    public function getrentalreviews()
    {
        $getrentalreviews = RentalReviews::with('User', 'Rental')->get();
        return response()->json(['success' => true, 'data' => $getrentalreviews]);
    }

    public function userrentalreviews($rental_id)
    {
        $userrentalreviews = RentalReviews::with('User', 'Rental')->where('rental_id', $rental_id)->get();
        return response()->json(['success' => true, 'data' => $userrentalreviews]);
    }

    // public function rentalimages(Request $req)
    // {
    //     $input = $req->all();
    //     $validator = Validator::make($input, [
    //         'rental_id' => 'required',
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
    //         $rentalreviews = RentalImages::where("id", $input['id'])->update($input);
    //         return response()->json(['success' => true, 'msg' => 'Rental Images Updated Successfully.']);
    //     } else {
    //         $rentalreviews = RentalImages::create($input);
    //         return response()->json(['success' => true, 'msg' => 'Rental Images Created Successfully', 'data' => $rentalreviews]);
    //     }
    // }

    public function rentalimages(Request $req)
    {
        try {
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
                    $image->storeAs('public/profileimage/', $imageName);

                    // $uploadedImages[] = $imageName;
                    $uploadedImages[] = 'profileimage/' . $imageName;
                }

                $input['image'] = $uploadedImages;
            }

            if (@$input['id']) {
                $rentalimages = RentalImages::where("id", $input['id'])->update($input);
                return response()->json(['success' => true, 'msg' => 'Rental Images Updated Successfully.']);
            } else {
                $rentalimages = [];
                foreach ($input['image'] as $rentalimage) {
                    $rentalimages[] = [
                        'rental_id' => $input['rental_id'],
                        'image' => $rentalimage,
                    ];
                }

                $rentalimages = RentalImages::insert($rentalimages);
                return response()->json(['success' => true, 'msg' => 'Rentals Images Created Successfully', 'data' => $rentalimages]);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getrentalimages()
    {
        $getrentalimages = RentalImages::with('Rental')->get();
        return response()->json(['success' => true, 'data' => $getrentalimages]);
    }

    public function userrentalimages($rental_id)
    {
        $userrentalimages = RentalImages::with('Rental')->where('rental_id', $rental_id)->get();
        return response()->json(['success' => true, 'data' => $userrentalimages]);
    }
}
