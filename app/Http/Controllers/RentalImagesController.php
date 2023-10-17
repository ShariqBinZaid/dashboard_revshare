<?php

namespace App\Http\Controllers;

use App\Http\Resources\RentalImagesResource;
use App\Models\RentalImages;
use App\Models\Rentals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentalImagesController extends Controller
{
    public function index()
    {
        $data['rentalimage'] = RentalImages::all();
        $data['rentals'] = Rentals::all();
        return view('rentalimages.index')->with($data);
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $rentals = RentalImages::get();
        return new RentalImagesResource($rentals);
    }

    // public function store(Request $req)
    // {
    //     $input = $req->all();
    //     // dd($input['image']);
    //     $validator = Validator::make($input, [
    //         'image' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'error' => $validator->errors()]);
    //     }

    //     if ($req->file('image')) {
    //         unset($input['image']);
    //         $input += ['image' => $this->updateprofile($req, 'image', 'profileimage')];
    //     }

    //     unset($input['_token']);

    //     if (@$input['id']) {
    //         $rentals = RentalImages::where("id", $input['id'])->update($input);
    //         return response()->json(['success' => true, 'msg' => 'Rental Images Updated Successfully.']);
    //     } else {
    //         $rentalimages = [];
    //         foreach ($input['image'] as $rentalimage) {
    //             $rentalimages[] = [
    //                 'rental_id' => $input['rental_id'],
    //                 'image' => $rentalimage,
    //             ];
    //         }

    //         $rentals = RentalImages::create($input);
    //         return response()->json(['success' => true, 'msg' => 'Rentals Images Created Successfully']);
    //     }
    // }

    public function store(Request $req)
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

        unset($input['_token']);

        if (@$input['id']) {
            $rentals = RentalImages::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Rental Images Updated Successfully.']);
        } else {
            $rentalimages = [];
            foreach ($input['image'] as $rentalimage) {
                $rentalimages[] = [
                    'rental_id' => $input['rental_id'],
                    'image' => $rentalimage,
                ];
            }

            RentalImages::insert($rentalimages);
            return response()->json(['success' => true, 'msg' => 'Rentals Images Created Successfully']);
        }
    }

    public function show($id)
    {
        if ($id ==  "all") {
            $rentals = RentalImages::all();
            return new RentalImagesResource($rentals);
        } else {
            $rentals = RentalImages::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $rentals]);
        }
    }

    public function destroy(Request $req, $id)
    {
        RentalImages::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Rental Images Deleted']);
    }
}
