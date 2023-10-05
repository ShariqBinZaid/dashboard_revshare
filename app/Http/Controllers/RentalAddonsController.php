<?php

namespace App\Http\Controllers;

use App\Models\RentalAddons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RentalAddonsResource;
use App\Models\Rentals;

class RentalAddonsController extends Controller
{
    public function index()
    {
        $data['rentals'] = Rentals::get();
        $data['rentaladdons'] = RentalAddons::all();
        return view('rentaladdons.index')->with($data);
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $rentaladdons = RentalAddons::with('Rental')->get();
        return new RentalAddonsResource($rentaladdons);
    }

    public function show($id)
    {
        if ($id ==  "all") {
            $rentaladdons = RentalAddons::all();
            return new RentalAddonsResource($rentaladdons);
        } else {
            $rentaladdons = RentalAddons::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $rentaladdons]);
        }
    }

    public function destroy(Request $req, $id)
    {
        RentalAddons::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Rentals Addons Deleted']);
    }

    public function store(Request $req)
    {
        $input = $req->all();
        dd($input);
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
            return response()->json(['success' => true, 'msg' => 'Rentals Addons Updated Successfully.']);
        } else {
            $names = [];
            $rental_id = $input['rental_id'];

            foreach ($input['name'] as $key => $name) {
                $price = $input['price'][$key];

                $names[] = [
                    'rental_id' => $rental_id,
                    'name' => $name,
                    'price' => $price,
                ];
            }
            $rentaladdons = RentalAddons::create($input);
            return response()->json(['success' => true, 'msg' => 'Rentals Addons Created Successfully']);
        }
    }
}
